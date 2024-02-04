<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ManagerJWTToken;
use Illuminate\Support\Facades\Cookie;

class AdminToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token_manager=Cookie::get('token_manager');
        $result=ManagerJWTToken::ReadToken($token_manager);
        if($result=="unauthorized"){
              return redirect('/manager/login');
        }
        else if($result->role=="admin"){
             return $next($request);
        }else{
              return response('Unauthorized', 401);
        }
    }
}
