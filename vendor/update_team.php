<?php
require_once '../config/connect.php';

$id_team = $_POST['id_team'];
$name_team = $_POST['name_team'];
$about_team = $_POST['about_team'];
$image_team = $_POST['image_team'];
$id_city = $_POST['id_city'];
$id_dancer = $_POST['id_dancer'];
$link_team = $_POST['link_team'];


mysqli_query($connect, "UPDATE `teams` SET `name_team` = '$name_team', `image_team` = '$image_team', `link_team` = '$link_team', 
`about_team` = '$about_team', `id_city` = '$id_city' WHERE `teams`.`id_team` = '$id_team'");

mysqli_query($connect, "DELETE FROM `dancer_team` WHERE `id_team` = '$id_team'");

foreach ($id_dancer as $id_dancer) {
    mysqli_query($connect, "INSERT INTO `dancer_team` (`id_dancer`, `id_team`) VALUES ('$id_dancer', '$id_team')");
}

header('Location: ../admin.php');
