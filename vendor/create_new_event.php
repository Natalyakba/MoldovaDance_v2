<?php
require_once '../config/connect.php';

$event_name = $_POST['event_name'];
$event_date = $_POST['event_date'];
$event_type = $_POST['event_type'];
$event_afisha = $_POST['event_afisha'];
$event_about = $_POST['event_about'];
$event_price = $_POST['event_price'];
$event_link = $_POST['event_link'];
$event_contact = $_POST['event_contact'];

$selectedCity = $_POST['cities'];
$otherCity = $_POST['otherCity'];

if ($selectedCity !== 'Other' && $selectedCity !== '') {
    // Используйте $selectedCity, выбранное значение из выпадающего списка
    $CITY = $selectedCity;
} else {
    $CITY = $otherCity;
}

$selectedDancer = $_POST['dancers'];
$otherDancer = $_POST['otherDancer'];

if ($selectedDancer !== 'Other' && $selectedDancer !== '') {
    // Используйте $selectedCity, выбранное значение из выпадающего списка
    $DANCER = $selectedDancer;
} else {
    $DANCER = $otherDancer;
}

$DANCER2 = mysqli_query($connect, "SELECT id_dancer FROM `dancers` WHERE name_dancer = '$DANCER';");
$DANCER = mysqli_fetch_row($DANCER2)[0];
