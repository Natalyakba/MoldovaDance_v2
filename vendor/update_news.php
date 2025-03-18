<?php
require_once '../config/connect.php';

$id_news = $_POST['id_news'];
$image_news = $_POST['image_news'];
$title_news = $_POST['title_news'];
$content_news = $_POST['content_news'];
$link_news = $_POST['link_news'];

mysqli_query($connect, "UPDATE `news` SET `image_news` = '$image_news', `title_news` = '$title_news', `content_news` = '$content_news', 
`link_news` = '$link_news' WHERE `news`.`id_news` = '$id_news'");

header('Location: ../admin.php');
