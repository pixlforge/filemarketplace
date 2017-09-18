<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use App\Http\Controllers\Controller;

class MarketplaceConnectController extends Controller
{
    /**
     * MarketplaceConnectController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'has.marketplace']);
    }

    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        session(['stripe_token' => str_random(60)]);

        return view('account.marketplace.index');
    }

    /**
     * Store
     *
     * @param Request $request
     * @param Guzzle $guzzle
     * @return mixed
     */
    public function store(Request $request, Guzzle $guzzle)
    {
        if (! $request->code) {
            return redirect()->route('account.connect')
                ->withDanger("There was a problem with your request.");
        }

        if ($request->state !== session('stripe_token')) {
            return redirect()->route('account.connect')
                ->withDanger("There was a problem with your request.");
        }

        $stripeRequest = $guzzle->request('POST', 'https://connect.stripe.com/oauth/token', [
            'form_params' => [
                'client_secret' => config('services.stripe.secret'),
                'code' => $request->code,
                'grant_type' => 'authorization_code'
            ]
        ]);

        $stripeResponse = json_decode($stripeRequest->getBody());

        $request->user()->update([
            'stripe_id' => $stripeResponse->stripe_user_id,
            'stripe_key' => $stripeResponse->stripe_publishable_key
        ]);

        return redirect()->route('account')
            ->withSuccess('You have now connected your Stripe account');
    }
}
