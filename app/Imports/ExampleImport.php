<?php

namespace App\Imports;

use App\Models\Example;

class ExampleImport extends BaseImport
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->currentIndex++;

        if( !$this->validate( $row ) ) { 
            $this->rejected++;
            $this->arrFailed[] = $row;
            $this->updateJobDetail();
            
            return null; 
        }
        
        $code = trim($row[1]);
        if( $this->checkExistsByCode( $code ) )
        {
            $this->updated++;
            Example::where('code', $code)->update([
                'name' => trim( $row[2] )
            ]);
            $this->updateJobDetail();
            return null;
        }
        else{
            $this->inserted++;
            $this->updateJobDetail();
            
            return new Example([
                'name'           => trim($row[2]),
                'code'           => trim($row[1])
            ]);
        }
    }

    private function checkExistsByCode( $code )
    {
        return Example::where('code', $code)->exists();
    }

    protected function validate(array $row)
    {
        return (
            isset($row[1]) &&
            isset($row[2]) 
        ) ? true : false;
    }
}
