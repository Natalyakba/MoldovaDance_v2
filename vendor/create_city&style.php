<?php
require_once '../config/connect.php';

// Добавление города и страны
$city = isset($_POST['name_city']) ? $_POST['name_city'] : null;
$country  = isset($_POST['name_country']) ? $_POST['name_country'] : null;

// Добавление стиля
$name_style = isset($_POST['name_style']) ? $_POST['name_style'] : null;
$about_style = isset($_POST['about_style']) ? $_POST['about_style'] : null;
$image_style = isset($_POST['image_style']) ? $_POST['image_style'] : null;
$video_style = isset($_POST['video_style']) ? $_POST['video_style'] : null;

// Добавление новостей
$title_news = isset($_POST['title_news']) ? $_POST['title_news'] : null;
$image_news = isset($_POST['image_news']) ? $_POST['image_news'] : null;
$content_news = isset($_POST['content_news']) ? $_POST['content_news'] : null;
$link_news = isset($_POST['link_news']) ? $_POST['link_news'] : null;

if ($city != null) {
    mysqli_query($connect, "INSERT INTO `cities` (`id_city`, `name_city`, `name_country`) VALUES (NULL, '$city', '$country')");
} elseif ($name_style != null) {
    mysqli_query($connect, "INSERT INTO `styles` (`id_style`, `name_style`, `about_style`, `video_style`, `image_style`) VALUES (NULL, '$name_style', '$about_style', '$video_style', '$image_style')");
} elseif ($title_news != null) {
    mysqli_query($connect, "INSERT INTO `news` (`id_news`, `image_news`, `title_news`, `content_news`, `link_news`) VALUES (NULL, '$image_news', '$title_news', '$content_news', '$link_news')");
}

header('Location: ../admin.php');
