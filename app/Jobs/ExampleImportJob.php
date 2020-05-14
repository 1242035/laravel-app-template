<?php

namespace App\Jobs;

use App\Imports\ExampleImport;
use Maatwebsite\Excel\Facades\Excel;

class ExampleImportJob extends BaseImportJob
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auth, $file, $start = 0, $email='diep.pham@amela.vn')
    {
        parent::__construct($auth, $file, $start, $email);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $jobId  = $this->getJobId();

        $import = new ExampleImport($this->auth, $this->start, $jobId, $this->email, $this->file);
        
        try {
            Excel::import($import, $this->file);
        } catch(\Exception $e){
            logger()->info('Exception', ['e' => $e]);
        }
        finally{
            //\Mail::to( $this->email )->send(new \App\Mail\ImportNotification($import));
        }
    }
}
