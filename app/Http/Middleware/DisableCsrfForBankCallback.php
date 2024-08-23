<?php
namespace App\Http\Middleware;

use Closure;

class DisableCsrfForBankCallback
{
    public function handle($request, Closure $next)
    {
        if ($request->is('payment_success') || $request->is('payment_error')) {
            // Bu rotada CSRF doğrulamasını devre dışı bırakın
            $request->session()->forget('_token');
        }

        return $next($request);
    }
}
