<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Encuestas\Encuesta;


class EmergencyCallReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $envio_token;
    
    public function __construct(Encuestas/Cargada, $envio_token)
    {
        $this->envio_token = $envio_token;
    }

  
    public function build()
    {
        return $this->view('emails.welcome');
    }
}
