<?php
Namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken{

    public static function CreateToken($userEmail,$userID):string{
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time()+60*60,
            'userEmail'=>$userEmail,
            'userID'=>$userID
        ];
       return JWT::encode($payload,$key,'HS256');
    }


    public function VerifyToken($token){
        try{
        $key =env('JWT_KEY');
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return $decoded->userEmail;

        }catch(Exception $e){
            return "unauthorized";

        }
       
    }





}

  


?>