<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class ManagerJWTToken
{
    public static function CreateToken($id,$name,$email,$hall_id,$role)
    {
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'rayhan-token',
            'iat'=>time(),
            'exp'=>time()+60*60*24*2,
            'id'=>$id,
            'email'=>$email,
            'manager_username'=>$name,
            'hall_id'=>$hall_id,
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
                $key =env('JWT_KEY');
                return JWT::decode($token,new Key($key,'HS256'));
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}

?>