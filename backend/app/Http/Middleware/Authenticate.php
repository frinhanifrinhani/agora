<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->auth->guard($guards[0])->guest()) {
            return response()->json(
                [
                    'error' => 'Not authorized'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
