<?php
require_once '../config/connect.php';

$name_theme = $_POST['name_theme'];
$theme_comment = $_POST['theme_comment'];

mysqli_query($connect, "INSERT INTO `newtopics` (`id_newtopic`, `name_newtopic`, `comment_newtopic`) VALUES (NULL, '$name_theme', '$theme_comment')");

header('Location: ../forum.php');
