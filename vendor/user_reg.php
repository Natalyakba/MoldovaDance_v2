<?php

session_start();
require_once '../config/connect.php';

$email_user = $_POST['email'];
$password_user = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$login_user = $_POST['login_user'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$date_of_birth = $_POST['date_of_birth'];


if ($password_user === $password_confirm) {

    // $password_user = md5($password_user);

    // Добавляем пользователя в базу данных
    mysqli_query($connect, "INSERT INTO `users` (`id_user`, `email_user`, `password_user`, `login_user`, `first_name`, `last_name`, `date_of_birth`) 
    VALUES (NULL, '$email_user', '$password_user', '$login_user', '$first_name', '$last_name', '$date_of_birth')");


    $_SESSION['message'] = 'Регистрация прошла успешно!';
    header('Location: ../index.php');
} 
else {
    // Если пароли не совпадают, не добавляем пользователя и показываем сообщение об ошибке
    $_SESSION['message'] = 'Пароли не совпадают';
    header('Location: ../registration.php');
}
?>


