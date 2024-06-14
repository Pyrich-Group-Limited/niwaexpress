<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerDocumentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $employerDocuments;
    public $user;
    public $areaManager;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employerDocuments, $user, $areaManager)
    {
        $this->employerDocuments = $employerDocuments;
        $this->user = $user;
        $this->areaManager = $areaManager;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Client Document Uploaded')
            ->view('emails.employer-document');
    }
}
