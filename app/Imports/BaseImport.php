<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithStartRow;

abstract class BaseImport implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue, WithEvents, WithStartRow
{
    const START = 1;
    const PROCESSING = 2;
    const FINISH = 3;

    protected $staus;

    protected $totalRow;

    protected $total;

    protected $inserted;

    protected $rejected;

    protected $updated;

    protected $arrFailed;

    protected $auth;

    protected $currentIndex;

    protected $start;

    protected $batchSize = 10;

    protected $chunkSize = 10;

    protected $jobId;

    protected $email;

    protected $path;

    public function __construct($auth, $start = 0, $jobId = 0, $email = 'diep.pham@amela.vn', $path = '')
    {
        $this->jobId = $jobId;
        $this->auth = $auth;
        $this->arrFailed = [];
        $this->totalRow = [];
        $this->total = 0;
        $this->inserted = 0;
        $this->rejected = 0;
        $this->updated = 0;
        $this->start = $start;
        $this->currentIndex = 0;
        $this->status = self::START;
        $this->email = $email;
        $this->path = $path;
        $this->processTotalCount();
    }

    public function registerEvents(): array
    {
        $me = $this;
        return [
            // Handle by a closure.
            BeforeImport::class => function(BeforeImport $event) use($me) {
                $me->totalRow = $event->reader->getTotalRows();
                $me->status = $me::PROCESSING;
                $me->processTotalCount();
            },
			AfterImport::class => function(AfterImport $event) use($me) {
                $me->status = $me::FINISH;
                $me->updateJobDetail(true);
                try{
                    unlink( $me->path );
                }catch(\Exception $e){}
            }          
        ];
    }

    private function processTotalCount()
    {
        foreach( $this->totalRow as $key => $sheetCount) {
            $this->total += ($sheetCount - $this->start );
        }
    }

    public function startRow(): int
    {
        return $this->start;
    }

    public function batchSize(): int
    {
        return $this->batchSize;
    }
    
    public function chunkSize(): int
    {
        return $this->chunkSize;
    }

    public function setAuth( $auth )
    {
        $this->auth = $auth;
    }

    public function getAuth()
    {
        return $this->auth;
    }
    
    protected function validate(array $row)
    {
        return true;
    }

    public function getTotalRow(): array
    {
        return $this->totalRow;
    }

    public function getTotalCount(): int
    {
        return $this->total;
    }

    public function getInsertCount(): int
    {
        return $this->inserted;
    }

    public function getRejectCount(): int
    {
        return $this->rejected;
    }

    public function getUpdateCount(): int
    {
        return $this->updated;
    }

    public function getArrFailed()
    {
        return $this->arrFailed;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getJobId()
    {
        return $this->jobId;
    }

    public function getCurrentIndex()
    {
        return $this->currentIndex;
    }

    public function getResponse()
    {
        return [
            'status'        => $this->getStatus(),
            'current_index' => $this->getCurrentIndex(),
            'total'         => $this->getTotalCount(),
            'inserted'      => $this->getInsertCount(),
            'rejected'      => $this->getRejectCount(),
            'updated'       => $this->getUpdateCount(),
            'arrFailed'     => json_encode($this->getArrFailed()),
            'arrFail'       => $this->getArrFailed(),
            'job_id'        => $this->getJobId()
        ];
    }

    public function updateJobDetail($force = false)
    {
        $job = \App\Models\JobImportDetail::where('job_id', $this->jobId)->first();
        if( $job ) 
        {
            if( $this->currentIndex == $this->chunkSize || $force) 
            {
                $data = $this->getResponse();
                //logger()->info('info',['data' => $data]);
                $arrFailedOld = json_decode( $job->arrFailed );
                if( ! is_array($arrFailedOld) ) {
                    $arrFailedOld = [];
                }
                $arrFailed = $arrFailedOld + $data['arrFail'];

                $job->status = $data['status'];
                $job->total  = $data['total'];
                $job->current_index += $data['current_index'];
                $job->inserted += $data['inserted'];
                $job->rejected += $data['rejected'];
                $job->updated  += $data['updated'];
                $job->arrFailed = json_encode( $arrFailed );
                $job->save();
            }
        }
        else{
            \App\Models\JobImportDetail::create( 
                $this->getResponse() 
            );
        }
    }
}
