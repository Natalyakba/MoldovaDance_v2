<?php
require_once '../config/connect.php';

$name_team = $_POST['name_team'];
$id_city = $_POST['id_city'];
$image_team = $_POST['image_team'];
$about_team = $_POST['about_team'];
$link_team = $_POST['link_team'];

mysqli_query($connect, "INSERT INTO `teams` (`id_team`, `name_team`, `image_team`, `link_team`, `about_team`, `id_city`) 
VALUES (NULL, '$name_team', '$image_team', '$link_team', '$about_team', '$id_city')");

$id_team = mysqli_insert_id($connect);
$id_dancer = $_POST['id_dancer'];

foreach ($id_dancer as $id_dancer) {
    mysqli_query($connect, "INSERT INTO `dancer_team` (`id_dancer`, `id_team`) VALUES ('$id_dancer', '$id_team')");
}

header('Location: ../admin.php');
