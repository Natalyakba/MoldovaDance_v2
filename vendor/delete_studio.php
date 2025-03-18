<?php
require_once '../config/connect.php';

$id_studio = $_GET['id_studio'];

mysqli_query($connect, "DELETE FROM `dancer_studio` WHERE `id_studio` = '$id_studio'");
mysqli_query($connect, "DELETE FROM `studio_style` WHERE `id_studio` = '$id_studio'");
mysqli_query($connect, "DELETE FROM `studios` WHERE `id_studio` = '$id_studio'");

header('Location: ../admin.php');
