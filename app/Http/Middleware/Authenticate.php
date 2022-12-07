<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    protected $user_route = 'user.login';

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(Route::is('user.*')){
                return route($this->user_route);
            }
        }
    }
}
