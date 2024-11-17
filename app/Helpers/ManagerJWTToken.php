<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class ManagerJWTToken
{
    public static function CreateToken($id,$name,$email,$hall_id,$role,$role2)
    {
        
        $key = "qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYryytr76675sdrgrk";
        $payload=[
            'iss'=>'rayhan-token',
            'iat'=>time(),
            'exp'=>time()+60*60*24*2,
            'id'=>$id,
            'email'=>$email,
            'manager_username'=>$name,
            'hall_id'=>$hall_id,
            'role'=>$role,
            'role2'=>$role2
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
                $key = "qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYryytr76675sdrgrk";
                return JWT::decode($token,new Key($key,'HS256'));
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}

?>