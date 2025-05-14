<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $address;

    public function __construct($order, $address)
    {
        $this->order = $order;
        $this->address = $address;
    }

    public function build()
    {
        return $this->subject('Confirmação do Pedido')
                    ->view('emails.order_confirmation');
    }
}