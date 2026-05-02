<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FirebaseSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('firebase_user.uid')) {
            return redirect('/login');
        }

        return $next($request);
    }
}