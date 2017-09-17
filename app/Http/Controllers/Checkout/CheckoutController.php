<?php

namespace App\Http\Controllers\Checkout;

use App\File;
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
}
