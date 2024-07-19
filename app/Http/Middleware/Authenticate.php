<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            throw new AuthenticationException(
                'Unauthenticated.', $guards, null
            );
        }

        return redirect()->guest(route('login'));
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
