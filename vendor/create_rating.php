<?php
require_once '../config/connect.php';

$id_user = $_POST['id_user'];
$id_event = $_POST['id_event'];
$comment = $_POST['comment'];
$rating = $_POST['rating'];

// var_dump($_POST);


mysqli_query($connect, "INSERT INTO `event_ratings` (`id`, `id_event`, `id_user`, `rating`, `comment`, `created_at`, `updated_at`) 
VALUES (NULL, '$id_event', '$id_user', '$rating', '$comment', current_timestamp(), current_timestamp())");

header('Location: ../index.php');
exit();
?>