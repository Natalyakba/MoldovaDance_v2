<?php
session_start();
require_once '../config/connect.php';

$email_user = $_POST['email'];
$password_user = $_POST['password'];
// $password_user = md5($_POST['password']); 

// Выполняем запрос для поиска пользователя
$check_user = mysqli_query($connect, 
    "SELECT u.*, c.name_city 
     FROM `users` u
     JOIN `cities` c ON u.id_city = c.id_city
     WHERE u.`email_user` = '$email_user' AND u.`password_user` = '$password_user'");

if (mysqli_num_rows($check_user) > 0) {
    // Получаем данные пользователя
    $user = mysqli_fetch_assoc($check_user);

    // Сохраняем данные в сессии
    $_SESSION['user'] = [
        "id_user" => $user['id_user'],
        "email_user" => $user['email_user'],
        "login_user" => $user['login_user'], 
        "first_name" => $user['first_name'], 
        "last_name" => $user['last_name'], 
        "phone_user" => $user['phone_user'], 
        "date_of_birth" => $user['date_of_birth'], 
        "city_user" => $user['name_city'],
    ];

    print_r($_SESSION);

    // Перенаправляем на страницу профиля
    header('Location: ../profile.php');
    exit();
//     header("Location: " . $_SERVER['REQUEST_URI']);
// exit();
} else {
    // Если пользователь не найден, показываем сообщение об ошибке
    $_SESSION['message'] = 'Неверный логин или пароль';
    header('Location: ../index.php');
    exit();
}
?>