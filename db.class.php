<?php

// PDO
class db
{

    static public $connect = null;

    // static private $tokenKey = 'sekret';
    static public function connectDb()
    {
        self::$connect = new PDO("mysql:host=ss_db;dbname=testParcel2212", "root", "123456");
        // $conn->exec(команда_sql);
    }

    static public function addParcel( $payload )
    {
        // $jwt = JWT::encode($payload, self::$tokenKey, 'HS256');
        // return $jwt;
    }

    static public function getParcel ( int $id)
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
