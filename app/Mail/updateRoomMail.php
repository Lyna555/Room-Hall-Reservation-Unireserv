<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class updateRoomMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($roomy,$room,$capacity,$floor)
    {
        $this->roomy=$roomy;
        $this->room=$room;
        $this->capacity=$capacity;
        $this->floor=$floor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mngRooms.updateRoomMail')->with(['roomy'=>$this->roomy,'room'=>$this->room,'capacity'=>$this->capacity,'floor'=>$this->floor]);
    }
}
