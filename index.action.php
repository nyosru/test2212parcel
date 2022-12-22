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

$inDb = job::validateStatusParcel($_POST, $userInfo);

if (!empty(job::$error))
    die('Найдена ошибка: ' . job::$error);

echo 'данные для сохранения';
echo '<pre>', print_r($inDb, true), '</pre>';

$addedId = db::addParcel($inDb);
echo 'Добавили, новый id: '.( $addedId ?? 'не найден, ошибка' );

// отправляем запрос в бд
