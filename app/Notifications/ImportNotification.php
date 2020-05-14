<?php

namespace App\Notifications;

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
        ->with($this->import->getResponse());
    }
}
