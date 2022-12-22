<?php

require './vendor/autoload.php';
require 'class.php';
require 'token.class.php';

echo '<h2>1. Авторизация</h2>';

echo '<table style="width:100%;"><tr><Td>';

echo '<form action="" method="POST" >
Логин: <input type="text" name="login" requery="">
<br/>
Пароль: <input type="password" name="password"  requery="">
<br/>
<button type="submit" >Войти</button>
</form>';

echo '</td><td>';

echo '<fieldset style="font-size:10px;" ><legend>имеющиеся логины</legend>';
echo '<pre>' . print_r(job::showUsers(), true) . '</pre>';
echo '</fieldset>';

echo '</td></tr></table>';

if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $result = job::enterLk($_POST['login'], $_POST['password']);
    if (!empty(job::$error)) {
        echo 'найдена ошибка: ' . job::$error;
    } else {

        echo '<div style="background-color: yellow; padding: 10px;" >ваш токен: ' . job::$token . '</div>';
    }
    echo '<pre>', print_r($result) . '</pre>';
}

// echo JWT::encode(
//     $data,
//     $secretKey,
//     'HS512'
// );

echo '<h2>1. запись данных</h2>';


echo '<table>
<tr>
    <td style="padding-right:25px;" >
    <form action="/index.action.php" target="my-iframe" method="post" >

    № посылки: <input type="number" min="0" max="9999999999" step="1" name="parcel_id" >
    <br/>
    новый статус: <select name="new_value" >
        <option value="" >Выберите</option>
        <option value="6" >В пути в город</option>
        <option value="15" >В пути в город-отправитель</option>
        <option value="19" >В пути в ИМ</option>
        <option value="2" >В пути в ТД</option>
        <option value="5" >Готов к отправке</option>
        <option value="14" >Готов к отправке в город-отправитель</option>
        <option value="18" >Готов к отправке в ИМ</option>
    </select>
    <br/>
    токен: <input type="text" name="token" >
    <br/>
    
    <button type="submit" >Отправить</button>
    </form>
    </td>    
    <td><iframe name="my-iframe" xsrc="iframe.php"></iframe></td>
    </tr></table>';

echo '<h2>3. получение данных</h2>';

echo '<table width="100%" >
<tr>
    <td style="width: 400px;padding-right:25px;" >
    <form action="/index.get.php" target="my-iframe2" method="post" >

    № посылки: <input type="number" min="0" max="9999999999" step="1" name="parcel_id" >
    <br/>
    новый статус: <select name="new_value" >
        <option value="" >Выберите</option>
        <option value="6" >В пути в город</option>
        <option value="15" >В пути в город-отправитель</option>
        <option value="19" >В пути в ИМ</option>
        <option value="2" >В пути в ТД</option>
        <option value="5" >Готов к отправке</option>
        <option value="14" >Готов к отправке в город-отправитель</option>
        <option value="18" >Готов к отправке в ИМ</option>
    </select>
    <br/>
    токен: <input type="text" name="token" >
    <br/>
    
    <button type="submit" >Отправить</button>
    </form>
    </td>    
    <td><iframe style="width:100%;height: 400px; border: 1px solid green; padding: 10px;"name="my-iframe2" xsrc="iframe.php"></iframe></td>
    </tr></table>';


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
</pre>


';
