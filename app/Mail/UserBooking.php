<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserBooking extends Mailable
{
    use Queueable, SerializesModels;
    public $userBooking;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userBooking)
    {
        $this->userBooking=$userBooking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('FomemaBooking@example.com')
        ->view('emails.userBooking');
    }
}
