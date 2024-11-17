<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class MaintainJWTToken
{
    public static function CreateToken($name,$email,$maintain_id,$role)
    {
        $key = "qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYryytr76675";
        $payload=[
            'iss'=>'rayhan-token',
            'iat'=>time(),
            'exp'=>time()+60*60*24*30,
            'email'=>$email,
            'maintain_username'=>$name,
            'maintain_id'=>$maintain_id,
            'role'=>$role
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
                $key = "qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYryytr76675";
                return JWT::decode($token, new Key($key, 'HS256'));
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}

?>