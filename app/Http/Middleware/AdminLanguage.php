<?php

namespace App\Http\Middleware;

use App\Nahau\AdminLang;
use Closure;
use Illuminate\Http\Request;

/** Translates admin pages, modals and JSON messages to English when the signed-in user picked English. */
class AdminLanguage
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if (AdminLang::current($request) !== 'en' || $response->isRedirection()) {
            return $response;
        }
        $type = (string) $response->headers->get('Content-Type');
        if (str_contains($type, 'text/html') || str_contains($type, 'json')) {
            $response->setContent(AdminLang::translate((string) $response->getContent()));
        }

        return $response;
    }
}
