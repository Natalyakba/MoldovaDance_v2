<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/connect.php';

// Получаем данные из формы
$name_dancer = $_POST['name_dancer'];
$id_city = $_POST['id_city'] ?: $_POST['id_city_md_dancer'] ?: $_POST['id_city_other_dancer'];
$photo_dancer = $_POST['photo_dancer'];
$link_dancer = $_POST['link_dancer'];
$about_dancer = $_POST['about_dancer'];
$id_dancer = $_POST['id_dancer']; // ID танцора, который нужно обновить или создать

$id_team = $_POST['teams'] ?? []; // Если команда не указана
$id_studio = $_POST['studios'] ?? []; // Если студия не указана
$is_teacher = isset($_POST['is_teacher']) && $_POST['is_teacher'] == '1' ? 1 : 0;
$id_style = $_POST['id_style'] ?? []; // Стили танца

// Проверяем, существует ли танцор с таким id_dancer
$query = mysqli_query($connect, "SELECT * FROM `dancers` WHERE `id_dancer` = '$id_dancer'");
$existing_dancer = mysqli_fetch_assoc($query);

// var_dump($_POST);
// var_dump($existing_dancer);

if ($existing_dancer) {
    // Если танцор существует, обновляем его данные
    $updateQuery = mysqli_prepare($connect, "UPDATE `dancers` SET 
        `name_dancer` = ?, `city_dancer` = ?, `photo_dancer` = ?, 
        `link_dancer` = ?, `about_dancer` = ?, `is_teacher` = ?  
    WHERE `id_dancer` = ?");
    mysqli_stmt_bind_param($updateQuery, 'ssssssi', $name_dancer, $id_city, $photo_dancer, $link_dancer, $about_dancer, $is_teacher, $id_dancer);
    mysqli_stmt_execute($updateQuery);

    // Удаляем старые связи
    mysqli_query($connect, "DELETE FROM `dancer_team` WHERE `id_dancer` = '$id_dancer'");
    mysqli_query($connect, "DELETE FROM `dancer_studio` WHERE `id_dancer` = '$id_dancer'");
    mysqli_query($connect, "DELETE FROM `dancer_style` WHERE `id_dancer` = '$id_dancer'");

} else {
    // Если танцора нет, создаём новый
    $insertQuery = mysqli_prepare($connect, "INSERT INTO `dancers` (`id_dancer`, `name_dancer`, `city_dancer`, `photo_dancer`, `link_dancer`, `about_dancer`, `is_teacher`) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($insertQuery, 'isssssi', $id_dancer, $name_dancer, $id_city, $photo_dancer, $link_dancer, $about_dancer, $is_teacher);
    mysqli_stmt_execute($insertQuery);

    // Получаем ID нового танцора (если это новая запись)
    $id_dancer = mysqli_insert_id($connect);
}

// Добавляем танцора в команды (если они есть)
if (!empty($id_team)) {
    foreach ($id_team as $team_id) {
        $query = "INSERT INTO `dancer_team` (`id_dancer`, `id_team`) VALUES ('$id_dancer', '$team_id')";
        if (!mysqli_query($connect, $query)) {
            echo "Ошибка выполнения запроса для команды: " . mysqli_error($connect);
        }
    }
}

// Добавляем танцора в студии (если они есть)
if (!empty($id_studio)) {
    foreach ($id_studio as $studio_id) {
        $query = "INSERT INTO `dancer_studio` (`id_dancer`, `id_studio`) VALUES ('$id_dancer', '$studio_id')";
        if (!mysqli_query($connect, $query)) {
            echo "Ошибка выполнения запроса для студии: " . mysqli_error($connect);
        }
    }
}

// Добавляем стили танцора (если они указаны)
if (!empty($id_style)) {
    foreach ($id_style as $style_id) {
        $query = "INSERT INTO `dancer_style` (`id_dancer`, `id_style`) VALUES ('$id_dancer', '$style_id')";
        if (!mysqli_query($connect, $query)) {
            echo "Ошибка выполнения запроса для стиля: " . mysqli_error($connect);
        }
    }
}

// Редирект на страницу после сохранения
header('Location: ../admin.php');
exit();
?>
