<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip_address = $request->ip();
        $session = session()->getId();
        // $get_session = Session::get('ip:', $ip_address);
        $get_session = Session::get('ip:' . $ip_address);
        if ($get_session) {
            if ($get_session !== $session) {
                return response()->json([
                    'error' => 'Another session is already working for this IP.',
                ], 429);
            }
        } else {
            Session::put('ip:' . $ip_address, $session, now()->addMinutes(2));
            // Session::put('ip:', $ip_address, $session, now()->addMinutes(2));
        }
        return $next($request);
    }
}
