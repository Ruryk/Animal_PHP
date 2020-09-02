<?php
require_once '../core/config.php';
require_once '../core/function.php';
$conn = connect();
// Функция для генерации случайной строки
function generateCode($length = 6)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    return $code;
}

// Соединямся с БД

if (isset($_POST['password'])) {
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($conn, "SELECT id, password FROM users WHERE email='{$_POST['email']}' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    // Сравниваем пароли
    if ($data['password'] === md5($_POST['password'])) {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($conn, "UPDATE users SET hash='$hash' WHERE id=".$data['id']);

        // Ставим куки
        setcookie("id", $data['id'], time()+30*24*60*60,"/");
        setcookie("hash", $hash, time()+30*24*60*60,"/"); // httponly !!!

        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: /");
        exit();
    } else {
        print "Вы ввели неправильный логин/пароль";
    }
}
close($conn);
?>