<?php
require_once 'lib/auth.php';

$auth = new AuthClass();

$login = @$_POST['login'];
$pass = @$_POST['pass'];

if (!empty($login) && !empty($pass)) { //Если логин и пароль были отправлены
    if (!$auth->auth($login, $pass)) { //Если логин и пароль введен не правильно
      header('Location: /?message=Неправильный логин или пароль');
    } else {
      header('Location: /');
    }
}
