<?php
require_once '../config/connect.php';

$id_studio = $_POST['id_studio'];
$name_studio = $_POST['name_studio'];
$about_studio = $_POST['about_studio'];
$image_studio = $_POST['image_studio'];
$id_city = $_POST['id_city'];
$id_style = $_POST['id_style'];
$id_dancer = $_POST['id_dancer'];
$schedule_studio = $_POST['schedule_studio'];
$link_studio = $_POST['link_studio'];

mysqli_query($connect, "UPDATE `studios` SET `name_studio` = '$name_studio', `image_studio` = '$image_studio', `about_studio` = '$about_studio', 
`schedule_studio` = '$schedule_studio', `city_studio` = '$id_city', `link_studio` = '$link_studio' WHERE `studios`.`id_studio` = '$id_studio'");

echo $link_studio;
mysqli_query($connect, "DELETE FROM `dancer_studio` WHERE `id_studio` = '$id_studio'");
mysqli_query($connect, "DELETE FROM `studio_style` WHERE `id_studio` = '$id_studio'");


foreach ($id_dancer as $id_dancer) {
    mysqli_query($connect, "INSERT INTO `dancer_studio` (`id_dancer`, `id_studio`) VALUES ('$id_dancer', '$id_studio')");
}
foreach ($id_style as $id_style) {
    mysqli_query($connect, "INSERT INTO `studio_style` (`id_studio`, `id_style`) VALUES ('$id_studio', '$id_style')");
}

header('Location: ../admin.php');
