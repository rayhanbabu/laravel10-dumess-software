<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class MemberJWTToken
{
    public static function CreateToken($name,$email,$member_id,$hall_id,$role)
    {
        $key = "qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYryytr76675sdrgrk56";
        $payload=[
            'iss'=>'rayhan-token',
            'iat'=>time(),
            'exp'=>time()+60*60*24*30,
            'email'=>$email,
            'name'=>$name,
            'member_id'=>$member_id,
            'hall_id'=>$hall_id,
            'role'=>$role,
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
                $key = "qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYryytr76675sdrgrk56";
                return JWT::decode($token,new Key($key,'HS256'));
            }

        }catch (Exception $e){
            return 'unauthorized';
        }
    }
}

?>