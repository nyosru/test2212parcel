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
