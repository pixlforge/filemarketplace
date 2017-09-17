<?php

namespace App\Listeners\Checkout;

use Illuminate\Support\Facades\Mail;
use App\Events\Checkout\SaleWasCreated;
use App\Mail\Checkout\SaleConfirmation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToBuyer
{
    /**
     * Handle the event.
     *
     * @param  SaleWasCreated  $event
     * @return void
     */
    public function handle(SaleWasCreated $event)
    {
        Mail::to($event->sale->buyer_email)
            ->queue(new SaleConfirmation($event->sale));
    }
}
