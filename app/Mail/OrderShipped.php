<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->from('no-reply@yourapp.com')
                    ->subject('Your Order Has Shipped!')
                    ->markdown('emails.orders.shipped')
                    ->with([
                        'orderNumber' => $this->order->id,
                        'shippingDate' => $this->order->shipping_date,
                    ]);
    }
}
