<?php

namespace App\Mail\Checkout;

use App\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaleConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $sale;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Purchase confirmation for {$this->sale->file->title}")
            ->view('emails.checkout.confirmation');
    }
}
