<?php

require './vendor/autoload.php';
require 'class.php';
require 'token.class.php';
require 'db.class.php';

// if (empty($_POST['token']))
//     die('заполните поле токен');

$userInfo = token::readToken($_POST['token']);

if (empty($userInfo->login))
    die('заполните поле токен верно');

    echo '<pre>', print_r($_POST, true), '</pre>';

$addedId = db::getParcel($_POST);


die('777');


$inDb = job::validateStatusParcel($_POST, $userInfo);

if (!empty(job::$error))
    die('Найдена ошибка: ' . job::$error);

echo 'данные для сохранения';
echo '<pre>', print_r($inDb, true), '</pre>';

$addedId = db::addParcel($inDb);
echo 'Добавили, новый id: '.( $addedId ?? 'не найден, ошибка' );

// отправляем запрос в бд

die();

echo '<h2>2. Запись данных</h2>';

echo '<form action="" method="POST" >
    Логин: <input type="text" name="login" requery="">
    <br/>
    Пароль: <input type="password" name="password"  requery="">
    <br/>
    <button type="submit" >Войти</button>
    </form>';

if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $result = job::enterLk($_POST['login'], $_POST['password']);
    if (!empty(job::$error)) {
        echo 'найдена ошибка: ' . job::$error;
    } else {
        echo 'ваш токен: ' . job::$token;
    }
    echo '<pre>', print_r($result) . '</pre>';
}

// echo JWT::encode(
//     $data,
//     $secretKey,
//     'HS512'
// );

echo '<pre>
1. авторизация
На вход метода подается пара логин,пароль: testUser/testPass
На выходе ожидается JWT token сроком жизни 10 минут
    2. запись данных
На вход метода подается JWT token, parcel_id, webshop_id, date_create
На выходе id созданной записи
либо ошибка если токен не прошел проверку
либо ошибка если переданы некорректные данные или что-то пошло не так
    3. получение данных
На вход метода подается JWT token и опциональные параметры выборки parcel_id, webshop_id, date_create
На выходе заказы удовлетворящие запросу
либо ошибка если токен не прошел проверку
либо ошибка если переданы некорректные данные или что-то пошло не так
</pre>';
