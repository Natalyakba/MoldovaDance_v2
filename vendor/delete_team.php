<?php
require_once '../config/connect.php';

$id_team = $_GET['id_team'];

mysqli_query($connect, "DELETE FROM `dancer_team` WHERE `id_team` = '$id_team'");
mysqli_query($connect, "DELETE FROM `teams` WHERE `id_team` = '$id_team'");

header('Location: ../admin.php');
