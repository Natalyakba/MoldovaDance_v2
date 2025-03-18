<?php
require_once '../config/connect.php';

$id_dancer = $_GET['id_dancer'];

mysqli_query($connect, "DELETE FROM `dancer_studio` WHERE `id_dancer` = '$id_dancer'");
mysqli_query($connect, "DELETE FROM `dancer_style` WHERE `id_dancer` = '$id_dancer'");
mysqli_query($connect, "DELETE FROM `dancer_team` WHERE `id_dancer` = '$id_dancer'");
mysqli_query($connect, "DELETE FROM `teachers` WHERE `id_dancer` = '$id_dancer'");
mysqli_query($connect, "DELETE FROM `dancers` WHERE `id_dancer` = '$id_dancer'");

header('Location: ../admin.php');
