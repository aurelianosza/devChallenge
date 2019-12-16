<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {

        if($request->auth->role === 2) {
            return $next($request);
        }        
        else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}