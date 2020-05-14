<?php

namespace App\Mail;

class ImportNotification extends Base
{

    public $import;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( \App\Imports\BaseImport $import )
    {
        $this->import = $import;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.import')
        ->with([
            'total'    => $this->import->getTotalCount(),
            'rejected' => $this->import->getRejectCount(),
            'inserted' => $this->import->getInsertCount(),
            'arrFailed'=> $this->import->getArrFailed()
        ]);
    }
}
