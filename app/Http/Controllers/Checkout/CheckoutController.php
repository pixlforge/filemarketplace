<?php

namespace App\Http\Controllers\Checkout;

use App\File;
use Stripe\Charge;
use Illuminate\Http\Request;
use App\Jobs\Checkout\CreateSale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\FreeCheckoutRequest;

class CheckoutController extends Controller
{
    /**
     * Checkout a free file.
     *
     * @param FreeCheckoutRequest $request
     * @param File $file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function free(FreeCheckoutRequest $request, File $file)
    {
        if (! $file->isFree()) {
            return back();
        }

        dispatch(new CreateSale($file, $request->email));

        return back()->withSuccess("We've emailed you your download link!");
    }

    /**
     * Checkout via Stripe.
     *
     * @param Request $request
     * @param File $file
     * @return mixed
     */
    public function payment(Request $request, File $file)
    {
        try {
            $charge = Charge::create([
                'amount' => $file->price * 100,
                'currency' => 'chf',
                'source' => $request->stripeToken,
                'application_fee' => $file->calculateCommission() * 100
            ], [
                'stripe_account' => $file->user->stripe_id
            ]);
        } catch (\Exception $e) {
            return back()->withDanger('Something went wrong with your payment, so we aborted the process. ' . $e->getMessage());
        }

        dispatch(new CreateSale($file, $request->stripeEmail));

        return back()->withSuccess("Payment complete! We've emailed you your download link!");
    }
}
