<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class ForgetJWTToken
{
    public static function CreateToken($email)
    {
         $key = "qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYryytr76675trgh";
         $payload=[
             'iss'=>'forget-token',
             'iat'=>time(),
             'exp'=>time()+60*5,
             'email'=>$email, 
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
                $key = "qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYryytr76675trgh";
                return JWT::decode($token,new Key($key,'HS256'));
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}

?>