<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class BookingJWTToken
{
    public static function CreateToken($booking_member_id,$hall_id,$phone)
    {
         $key =env('JWT_KEY');
         $payload=[
             'iss'=>'rayhan-token',
             'iat'=>time(),
             'exp'=>time()+60*60*24*2,
             'phone'=>$phone,
             'booking_member_id'=>$booking_member_id,
             'hall_id'=>$hall_id,
          ];
          return JWT::encode($payload,$key,'HS256');
     }

    public static function ReadToken($token)
    {
        try {
            if($token==null){
                return 'unauthorized';
            }
            else{
                $key =env('JWT_KEY');
                return JWT::decode($token,new Key($key,'HS256'));
            }

        }catch (Exception $e){
            return 'unauthorized';
        }
    }
}

?>