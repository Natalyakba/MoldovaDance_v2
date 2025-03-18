<?php
require_once '../config/connect.php';

$id_news = $_GET['id_news'];

mysqli_query($connect, "DELETE FROM `news` WHERE `id_news` = '$id_news'");

header('Location: ../admin.php');
