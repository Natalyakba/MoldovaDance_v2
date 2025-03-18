<?php
require_once '../config/connect.php';

$name_studio = $_POST['name_studio'];
$id_city = $_POST['id_city'];
$image_studio = $_POST['image_studio'];
$about_studio = $_POST['about_studio'];
$link_studio = $_POST['link_studio'];
$schedule_studio = $_POST['schedule_studio'];

mysqli_query($connect, "INSERT INTO `studios` (`id_studio`, `name_studio`, `image_studio`, `about_studio`, `schedule_studio`, `city_studio`, `link_studio`) 
VALUES (NULL, '$name_studio', '$image_studio', '$about_studio', '$schedule_studio', '$id_city', '$link_studio')");

$id_studio = mysqli_insert_id($connect);

$id_dancer = $_POST['id_dancer'];
foreach ($id_dancer as $id_dancer) {
    mysqli_query($connect, "INSERT INTO `dancer_studio` (`id_dancer`, `id_studio`) VALUES ('$id_dancer', '$id_studio')");
}

$id_style = $_POST['id_style'];
foreach ($id_style as $id_style) {
    mysqli_query($connect, "INSERT INTO `studio_style` (`id_studio`, `id_style`) VALUES ('$id_studio', '$id_style')");
}

header('Location: ../admin.php');
