<?php
session_start();
require_once '../config/connect.php';

$email_user = $_POST['email'];
$password_user = $_POST['password'];
// $password_user = md5($_POST['password']); 

// Выполняем запрос для поиска пользователя
$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `email_user` = '$email_user' AND `password_user` = '$password_user'");

if (mysqli_num_rows($check_user) > 0) {
    // Получаем данные пользователя
    $user = mysqli_fetch_assoc($check_user);

    // Сохраняем данные в сессии
    $_SESSION['user'] = [
        "id_user" => $user['id_user'],
        "email_user" => $user['email_user'],
        "login_user" => $user['login_user'], 
    ];

    // Перенаправляем на страницу профиля
    header('Location: ../profile.php');
    exit();
} else {
    // Если пользователь не найден, показываем сообщение об ошибке
    $_SESSION['message'] = 'Неверный логин или пароль';
    header('Location: ../index.php');
    exit();
}
?>