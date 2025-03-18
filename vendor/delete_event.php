<?php
require_once '../config/connect.php';

$id_event = $_GET['id_event'];

mysqli_query($connect, "DELETE FROM `event_guest` WHERE `id_event` = '$id_event'");
mysqli_query($connect, "DELETE FROM `event_style` WHERE `id_event` = '$id_event'");
mysqli_query($connect, "DELETE FROM `events` WHERE `id_event` = '$id_event'");

header('Location: ../admin.php');
