<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailingService extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $subject;
    public $filePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $subject, $filePath)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.SalarySlip')
            ->attachFromStorage($this->filePath, 'salaryslip.pdf', [
                'mime' => 'application/pdf'
            ]);;
    }
}
