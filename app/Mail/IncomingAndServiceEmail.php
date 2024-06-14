<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class IncomingAndServiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $incoming;
    public $user;
    public $areaManager;
    public $serviceApplication;
    public $documentInput;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($incoming, $user, $areaManager, $serviceApplication, $documentInput)
    {
        $this->incoming = $incoming;
        $this->user = $user;
        $this->areaManager = $areaManager;
        $this->serviceApplication = $serviceApplication;
        $this->documentInput = $documentInput;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Incoming Letter & Service Application')
            ->view('emails.incoming-letter-service');
    }

    
}
