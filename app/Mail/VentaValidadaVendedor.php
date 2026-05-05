<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Venta;

class VentaValidadaVendedor extends Mailable
{
    public $venta;

    public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }

    public function build()
    {
        return $this->subject('Venta Validada')
                    ->view('emails.vendedor');
    }
}