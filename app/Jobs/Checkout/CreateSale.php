<?php

namespace App\Jobs\Checkout;

use App\File;
use App\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Events\Checkout\SaleWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateSale implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;

    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(File $file, $email)
    {
        $this->file = $file;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sale = new Sale;

        $this->file->price = 20;

        $sale->fill([
            'identifier' => uniqid(true),
            'buyer_email' => $this->email,
            'sale_price' => $this->file->price,
            'sale_commission' => $this->file->calculateCommission()
        ]);

        $sale->file()->associate($this->file);
        $sale->user()->associate($this->file->user);

        $sale->save();

        event(new SaleWasCreated($sale));
    }
}
