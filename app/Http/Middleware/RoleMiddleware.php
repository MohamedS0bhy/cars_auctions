<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(isset($_COOKIE['token'])){

            JWTAuth::setToken($_COOKIE['token']);
            $usr = JWTAuth::toUser();
            
            if($usr->role == '1')
                return redirect()->route('adminPanel');
            else
                return redirect()->route('homeRoute');
          }
        return $next($request);
    }
}
