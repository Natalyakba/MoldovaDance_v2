<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/connect.php';

$event_name = $_POST['event_name'];
$event_date = $_POST['event_date'];
$event_about = $_POST['event_about'];
$event_afisha = $_POST['event_afisha'];

$id_city = $_POST['id_city'] ?: $_POST['id_city_md'] ?: $_POST['id_city_other'];
$event_type = $_POST['event_type'];

$event_price = $_POST['event_price'];
$event_link = $_POST['event_link'];
$event_contact = $_POST['event_contact'];

$id_styles = $_POST['id_style'] ?? [];
$id_dancers = $_POST['id_dancer'] ?? [];

// проверка: редактируем или создаём
if (!empty($_POST['id_event'])) {
    // Редактирование
    $id_event = $_POST['id_event'];

    // Обновляем саму запись
    mysqli_query($connect, "UPDATE `events` SET 
        `event_name` = '$event_name',
        `event_date` = '$event_date',
        `event_city` = '$id_city',
        `event_afisha` = '$event_afisha',
        `event_about` = '$event_about',
        `event_link` = '$event_link',
        `event_contact` = '$event_contact',
        `event_type` = '$event_type',
        `event_price` = '$event_price'
    WHERE `id_event` = '$id_event'");

    // Удаляем старые связи
    mysqli_query($connect, "DELETE FROM `event_style` WHERE `id_event` = '$id_event'");
    mysqli_query($connect, "DELETE FROM `event_guest` WHERE `id_event` = '$id_event'");

} else {
    // Создание
    mysqli_query($connect, "INSERT INTO `events` (`event_name`, `event_date`, `event_city`, `event_afisha`, `event_about`, `event_link`, `event_contact`, `event_type`, `event_price`) 
        VALUES ('$event_name', '$event_date', '$id_city', '$event_afisha', '$event_about', '$event_link', '$event_contact', '$event_type', '$event_price')");
    
    $id_event = mysqli_insert_id($connect); // получаем ID нового события
}

// Вставляем новые связи
foreach ($id_styles as $style_id) {
    mysqli_query($connect, "INSERT INTO `event_style` (`id_event`, `id_style`) VALUES ('$id_event', '$style_id')");
}

foreach ($id_dancers as $dancer_id) {
    mysqli_query($connect, "INSERT INTO `event_guest` (`id_event`, `id_dancer`) VALUES ('$id_event', '$dancer_id')");
}

header('Location: ../admin.php');
