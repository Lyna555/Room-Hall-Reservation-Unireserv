<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class contactusMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email,$university,$faculty,$msg)
    {
        $this->name=$name;
        $this->email=$email;
        $this->university=$university;
        $this->faculty=$faculty;
        $this->msg=$msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('contactusMail')->with(['name'=>$this->name,'email'=>$this->email,'university'=>$this->university,'faculty'=>$this->faculty,'msg'=>$this->msg]);
    }
}
