<?php

// PDO
class db
{

    static public $db = null;

    // static private $tokenKey = 'sekret';
    static public function connectDb()
    {

        try {
            self::$db = new PDO("mysql:host=ss_db;dbname=testParcel2212;charset=utf8mb4", "root", "123456");
            // $conn->exec(команда_sql);
        }
        // если к локальной бд не подключились, пробуем сервер
        catch (\Throwable $th) {
            self::$db = new PDO("mysql:host=localhost;dbname=parcel2212", "parcel", "parcel123");
        }
    }

    static public function addParcel(array $payload)
    {

        if (self::$db === null)
            self::connectDb();

        $payload['date_create'] = date('Y-m-d H:i:s');
        $payload['order_log_event_type_title'] = 'title';
        $payload['new_value_title'] = 'title';

        $str0 =
            $str = '';
        $in = [];

        foreach ($payload as $k => $v) {
            $str0 .= (!empty($str0) ? ', ' : '') . ' `' . $k . '` ';
            // $str .= (!empty($str) ? ', ' : '') . ' :' . $k . ' ';
            // $str .= (!empty($str) ? ', ' : '') . ' `' . $k . '` = ? ';
            // $str .= (!empty($str) ? ', ' : '') . ' `' . $k . '` = \'' . $v . '\' ';
            // $str .= (!empty($str) ? ', ' : '') . ' \'' . $v . '\' ';
            $str .= (!empty($str) ? ', ' : '') . ' :' . $k . ' ';
            $in[':' . $k] = $v;
            // $in[$k] = $v;
            // $in[] = $v;
        }

        echo __FILE__ . ' #' . __LINE__;
        echo '<Br/>';
        echo $str;

        echo '<pre>', print_r($in, true), '</pre>';

        // $sth = $db->prepare("INSERT INTO `parcel_log` SET `parent` = :parent, `name` = :name");
        $sql0 = 'INSERT INTO `parcel_log` ( ' . $str0 . ' ) VALUES ( ' . $str . ' )';
        echo '<br/>' . $sql0 . '<br/>';
        // $sql = self::$db->prepare($sql0, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sql = self::$db->prepare($sql0, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $ee = $sql->execute($in);
        echo '<br/>';
        echo $ee;
        echo '<br/>';

        // Получаем id вставленной записи        
        return self::$db->lastInsertId();
    }

    static public function getParcel($param = [])
    {

        if (self::$db === null)
            self::connectDb();



        $in = [];

        $sqlWhere = '';

        if (!empty($param)) {
            foreach ($param as $k => $v) {
                if ( (
                    $k == 'parcel_id' ||
                    $k == 'new_value'
                ) && !empty($v)
                ) {
                    $sqlWhere .= (!empty($sqlWhere) ? ' AND ' : '') . ' `' . $k . '` = :' . $k;
                    $in[$k] = $v;
                }
            }
        }

        // $sth = $db->prepare("INSERT INTO `parcel_log` SET `parent` = :parent, `name` = :name");
        // $sql0 = 'SELECT * FROM `parcel_log` '.().' LIMIT 20; ';
        $sql0 = 'SELECT * FROM `parcel_log` ' . (!empty($sqlWhere) ? ' WHERE ' . $sqlWhere : '') . ' ;';
        echo '<br/>' . $sql0 . '<br/>';
        // $sql = self::$db->prepare($sql0, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sql = self::$db->prepare($sql0);
        // $sql = self::$db->query($sql0);
        $sql->execute($in);
        $ee = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>', print_r($ee), '</pre>';
        // try {
        //     // JWT::$leeway = 600;
        //     // $decoded = JWT::decode($token, new Key(self::$tokenKey, 'HS256'));
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     $decoded = false;
        // }

        // print_r($decoded);
        return $decoded;

        // return 'sdfsdf';
    }
}
