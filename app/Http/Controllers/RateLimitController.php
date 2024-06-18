<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RateLimitController extends Controller
{
    public function checkRateLimit()
    {
        try {
            return view('rate-limit');
        } catch (\Exception $e) {
            \Log::info($e);
        }
    }

    public function createSession(Request $request)
    {
        $ipAddress = $request->ip();
        $session = session()->getId();
        $sessionKey = 'ip:' . $ipAddress;

        if (Session::has($sessionKey)) {
            if (Session::get($sessionKey) == $session) {
                Session::forget($sessionKey);
            }
            session()->regenerate();
        }
        Session::put($sessionKey, session()->getId());
        return redirect('/');
    }
}
