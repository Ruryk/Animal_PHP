<?php
require_once 'core/config.php';
require_once 'core/function.php';

// Скрипт проверки

if (isset($_COOKIE['id']) && isset($_COOKIE['hash']))
{
    
// Соединямся с БД
    $conn= connect();
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id =".intval($_COOKIE['id'])." LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    close($conn);
    if(($userdata['hash'] !== $_COOKIE['hash']) || ($userdata['id'] !== $_COOKIE['id']))
    {
        setcookie("id", "", time()-30*24*60*60, "/");
        setcookie("hash", "", time()-30*24*60*60, "/");
        header('Location: /login');

    }
}
else {
    header('Location: /login');
}
?>