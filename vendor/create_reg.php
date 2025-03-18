<?php
require_once '../config/connect.php';

$first_name = $_POST['first_name'];
$second_name = $_POST['second_name'];
$phone_number = $_POST['phone_number'];
$id_event = $_POST['id_event'];

mysqli_query($connect, "INSERT INTO `registration` (`id_registration`, `id_event`, `firstname_registration`, `lastname_registration`, `phone_registration`) VALUES (NULL, '$id_event', '$first_name', '$second_name', '$phone_number')");

header('Location: ../events.php');
