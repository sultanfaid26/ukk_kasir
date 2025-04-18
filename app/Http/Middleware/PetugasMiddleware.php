<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\Role;

class PetugasMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === Role::Petugas) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'You do not have petugas access.');
    }
}
