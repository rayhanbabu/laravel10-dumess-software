<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ManagerJWTToken;
use Illuminate\Support\Facades\Cookie;

class BookingSeatToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       if(booking_access()){
            return $next($request);
        }else{
           return response('Unauthorized', 401);
         }
    }
}
