<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class updateReserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserr,$reservation)
    {
        $this->reserr=$reserr;
        $this->reservation=$reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mngReservations.updateReserMail')->with(['reserr'=>$this->reserr,'reservation'=>$this->reservation]);
    }
}
