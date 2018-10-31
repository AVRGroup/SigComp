<?php
/**
 * Created by PhpStorm.
 * User: Lidiane
 * Date: 31/10/2018
 * Time: 19:40
 */
// eg: https://my.flarum.url/auth.php?token=123456
$expire = time() + (86400 * 30);
setcookie('flarum_remember', $_GET['token'], $expire, "/");
header("Location: https://200.131.219.56/flarum");