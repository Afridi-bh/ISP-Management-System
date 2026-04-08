<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // If not authenticated and trying to access admin routes, redirect to admin login
        if (!$request->expectsJson()) {
            return route('login');
        }
        
        return null;
    }
}