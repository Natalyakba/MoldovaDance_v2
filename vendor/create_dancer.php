<?php
require_once '../config/connect.php';

$name_dancer = $_POST['name_dancer'];
$id_city = $_POST['id_city'];
$photo_dancer = $_POST['photo_dancer'];
$link_dancer = $_POST['link_dancer'];
$about_dancer = $_POST['about_dancer'];

mysqli_query($connect, "INSERT INTO `dancers` (`id_dancer`, `name_dancer`, `city_dancer`, `photo_dancer`, `link_dancer`, `about_dancer`) 
VALUES (NULL, '$name_dancer', '$id_city', '$photo_dancer', '$link_dancer ', '$about_dancer')");

$id_dancer = mysqli_insert_id($connect);

$id_team = isset($_POST['id_team']) ? $_POST['id_team'] : null;
if ($id_team != null) {
    foreach ($id_team as $id_team) {
        mysqli_query($connect, "INSERT INTO `dancer_team` (`id_dancer`, `id_team`) VALUES ('$id_dancer', '$id_team')");
    }
}

$id_studio = isset($_POST['id_studio']) ? $_POST['id_studio'] : null;

$is_teacher = isset($_POST['is_teacher']) ? $_POST['is_teacher'] : null;
if ($is_teacher != null) {
    mysqli_query($connect, "INSERT INTO `teachers` (`id_teacher`, `id_dancer`) VALUES (NULL, '$id_dancer')");
    if ($id_studio != null) {
        foreach ($id_studio as $id_studio) {
            mysqli_query($connect, "INSERT INTO `dancer_studio` (`id_dancer`, `id_studio`) VALUES ('$id_dancer', '$id_studio')");
        }
    }
}

$id_style = $_POST['id_style'];
foreach ($id_style as $id_style) {
    mysqli_query($connect, "INSERT INTO `dancer_style` (`id_dancer`, `id_style`) VALUES ('$id_dancer', '$id_style')");
}

header('Location: ../admin.php');
