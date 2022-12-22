<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class job
{

    private static $user_password = [
        'user1' => [
            'workshop_id' => 1,
            'password' => 123
        ],
        'user2' => [
            'workshop_id' => 2,
            'password' => 123123
        ],
        'user3' => [
            'workshop_id' => 3,
            'password' => 123123123
        ],
    ];
    static $error = '';
    static $token = '';

    static public function showUsers()
    {
        return self::$user_password;
    }


    static public function enterLk($login = '', $password = '')
    {
        self::validate($login);
        if (!empty(self::$error)) {
            // return self::$error;
            return false;
        }
        self::validate($password, 'password');
        if (!empty(self::$error)) {
            // return self::$error;
            return false;
        }

        // проверяем есть нет логин пароль
        if (isset(self::$user_password[$login]) && self::$user_password[$login]['password'] == $password) {

            if (!isset(self::$user_password[$login]))
                return false;

            $payload = self::$user_password[$login];
            // безопасность всё такое, пароль дополнительно хранить и показывать не стоит
            unset($payload['password']);
            $payload['login'] = $login;

            self::$token = token::creatToken($payload);

            return true;
        }
        // если нет то ошибка
        else {
            self::$error = 'Логин Пароль указаны не верно';
            return false;
        }
    }

    /**
     * если валидация прошла с ошибкой то пишем ошибку в переменную $error
     */
    static public function validateStatusParcel(array $post, Object $user)
    {

        $return = [
            'parcel_id' => self::validate($post['parcel_id'] ?? '', 'number', 'номер посылки'),
            'workshop_id' => self::validate($user->workshop_id ?? '', 'number', 'номер клиента'),
            'new_value' => self::validate($post['new_value'] ?? '', 'number', 'новый статус')
        ];

        if (!empty(self::$error)) {
            return false;
        }

        return $return;
    }

    /**
     * если валидация прошла с ошибкой то пишем ошибку в переменную $error
     */
    public static function validate($val = '', $type = 'login', $poleName = '')
    {

        // показываем только первую ошибку
        if (!empty(self::$error))
            return false;

        if (empty($val)) {
            self::$error = (!empty($PoleName) ? $PoleName . ': ' : '') . 'не заполнено';
            return false;
        } else {

            if ($type == 'number') {
                if (!is_numeric($val)) {
                    self::$error = (!empty($PoleName) ? $PoleName . ': ' : '') . 'укажите верный номер посылки';
                    return false;
                }
            }

            if ($type == 'password') {
                if (strlen($val) < 3) {
                    self::$error = (!empty($PoleName) ? $PoleName . ': ' : '') . 'длинна должна быть не менее 3х символов';
                    return false;
                }
            }

            if ($type == 'login') {
                if (strpos($val, 's') == false) {
                    self::$error = (!empty($PoleName) ? $PoleName . ': ' : '') . 'поле Логин заполнено не верно';
                    return false;
                }
            }
        }

        return $val;
    }
}
