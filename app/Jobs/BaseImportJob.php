<?php

namespace App\Jobs;

use Maatwebsite\Excel\Facades\Excel;

class BaseImportJob extends BaseJob
{

    public $file;

    public $start;

    public $auth;

    public $email;

    public $__id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auth, $file, $start = 0, $email='email@email.com')
    {
        $this->auth = $auth;
        $this->file = $file;
        $this->start = $start;
        $this->email = $email;
        $this->__id    = md5(microtime(true));
    }

    public function getJobId()
    {
        return $this->__id;
    }
}
