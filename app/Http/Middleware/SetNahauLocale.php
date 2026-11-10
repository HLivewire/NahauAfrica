<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetNahauLocale
{
    public function handle(Request $request, Closure $next, string $locale = 'en')
    {
        app()->setLocale($locale);

        return $next($request);
    }
}
