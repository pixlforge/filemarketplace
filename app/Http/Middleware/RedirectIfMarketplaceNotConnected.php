<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfMarketplaceNotConnected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->user()->stripe_id) {
            return redirect()->route('account.connect')
                ->withDanger('Your account is currently not connected to Stripe. Please connect your account to Stripe.');
        }

        return $next($request);
    }
}
