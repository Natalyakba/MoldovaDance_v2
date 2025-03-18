<?php
require_once '../config/connect.php';

$id_event = $_POST['id_event'];
$event_name = $_POST['event_name'];
$event_date = $_POST['event_date'];
$event_about = $_POST['event_about'];
$event_afisha = $_POST['event_afisha'];

$id_city = $_POST['id_city'];
$event_type = $_POST['event_type'];

$event_price = $_POST['event_price'];
$event_link = $_POST['event_link'];
$event_contact = $_POST['event_contact'];

mysqli_query($connect, "UPDATE `events` SET `event_name` = '$event_name', `event_date` = '$event_date', 
`event_city` = '$id_city ', `event_afisha` = '$event_afisha', `event_about` = '$event_about', `event_link` = '$event_link', 
`event_contact` = '$event_contact', `event_type` = '$event_type', `event_price` = '$event_price' 
WHERE `events`.`id_event` = '$id_event'");

mysqli_query($connect, "DELETE FROM `event_guest` WHERE `id_event` = '$id_event'");
mysqli_query($connect, "DELETE FROM `event_style` WHERE `id_event` = '$id_event'");

$id_style = $_POST['id_style']; // массив
$id_dancer = $_POST['id_dancer'];  // массив

foreach ($id_style as $id_style) {
    mysqli_query($connect, "INSERT INTO `event_style` (`id_event`, `id_style`) VALUES ('$id_event', '$id_style')");
}

foreach ($id_dancer as $id_dancer) {
    mysqli_query($connect, "INSERT INTO `event_guest` (`id_event`, `id_dancer`) VALUES ('$id_event', '$id_dancer')");
}

header('Location: ../admin.php');
