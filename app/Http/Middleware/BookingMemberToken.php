<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\BookingJWTToken;
use Illuminate\Support\Facades\Cookie;

class BookingMemberToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $booking_token=$request->header('booking_token');
         $result=BookingJWTToken::ReadToken($booking_token);
         if($result=="unauthorized"){
                 return response('Unauthorized', 501);
          }else { 
                $request->headers->set('phone',$result->phone);
                $request->headers->set('booking_member_id',$result->booking_member_id);
                $request->headers->set('hall_id',$result->hall_id);
                return $next($request);
          }
    }
}
