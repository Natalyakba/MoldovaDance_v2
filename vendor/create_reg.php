<?php
require_once '../config/connect.php';

$first_name = $_POST['first_name'];
$second_name = $_POST['second_name'];
$phone_number = $_POST['phone_number'];
$id_event = $_POST['id_event'];
$id_user = $_POST['id_user'];

// print_r($id_user);

if ($id_user){
    mysqli_query($connect, "INSERT INTO `registrations` (`id_event`, `id_user`, `firstname_registration`, `lastname_registration`, `phone_registration`) VALUES ('$id_event', '$id_user', '$first_name', '$second_name', '$phone_number')");
}
else {
    mysqli_query($connect, "INSERT INTO `registrations` (`id_event`, `id_user`, `firstname_registration`, `lastname_registration`, `phone_registration`) VALUES ('$id_event', NULL, '$first_name', '$second_name', '$phone_number')");

};

header('Location: ../events.php');
