<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ManagerJWTToken;
use Illuminate\Support\Facades\Cookie;

class ManagerToken
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
         }else { 
              $request->headers->set('email',$result->email);
              $request->headers->set('hall_id',$result->hall_id);
              $request->headers->set('role',$result->role);
              $request->headers->set('id',$result->id);
              $request->headers->set('manager_username',$result->manager_username);
              return $next($request);
        }
    }
}
