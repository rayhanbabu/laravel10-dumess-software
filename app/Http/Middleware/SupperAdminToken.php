<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\MaintainJWTToken;
use Illuminate\Support\Facades\Cookie;

class SupperAdminToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token_maintain=Cookie::get('token_maintain');
        $result=MaintainJWTToken::ReadToken($token_maintain);
        if($result=="unauthorized"){
              return redirect('/maintain/login');
        }
        else if($result->role=="supperadmin"){
             return $next($request);
        }else{
              return response('Unauthorized', 401);
        }
    }
}
