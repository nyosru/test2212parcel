<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class token
{
    
    static private $tokenKey = 'sekret';

    static public function creatToken( $payload )
    {

        $jwt = JWT::encode($payload, self::$tokenKey, 'HS256');

        return $jwt;
    }

    static public function readToken(string $token)
    {

        try {
            JWT::$leeway = 600;
            $decoded = JWT::decode($token, new Key(self::$tokenKey, 'HS256'));
        } catch (\Throwable $th) {
            //throw $th;
            $decoded = false;
        }

        // print_r($decoded);
        return $decoded;

        // return 'sdfsdf';
    }

}
