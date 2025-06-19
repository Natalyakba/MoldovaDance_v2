<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json');

// Подключение к базе
require_once '../config/connect.php';

// Получаем данные
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_event'], $data['id_user'], $data['interaction_type'])) {
    echo json_encode(['success' => false, 'message' => 'Некорректные данные']);
    exit;
}

$id_event = intval($data['id_event']);
$id_user = intval($data['id_user']);
$interaction_type = intval($data['interaction_type']); // 0 = Skip, 1 = Like

// Вставка в базу через mysqli
$query = "INSERT INTO user_event_interactions (id_user, id_event, interaction_type) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($connect, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'iii', $id_user, $id_event, $interaction_type);
    mysqli_stmt_execute($stmt);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка подготовки запроса']);
}
