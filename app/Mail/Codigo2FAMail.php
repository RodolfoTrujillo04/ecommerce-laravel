<?php

namespace App\Mail;


use Illuminate\Mail\Mailable;


class Codigo2FAMail extends Mailable
{
    public $codigo;

    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    public function build()
    {
        return $this->subject('Código de verificación')
                    ->view('emails.codigo');
    }
}