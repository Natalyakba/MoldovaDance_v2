<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/connect.php';

if (!isset($_GET['id_dancer'])) {
    echo json_encode(['error' => 'No dancer ID provided']);
    exit;
}

$id_dancer = intval($_GET['id_dancer']); // Защита от SQL-инъекций

// Получаем данные о танцоре
$query = "
    SELECT 
        dancers.id_dancer, 
        dancers.name_dancer, 
        dancers.about_dancer, 
        dancers.link_dancer, 
        dancers.photo_dancer,
        dancers.is_teacher,
        cities.name_city,
        dancers.city_dancer -- id города тоже нужно для скрытого поля
    FROM dancers
    LEFT JOIN cities ON dancers.city_dancer = cities.id_city
    WHERE dancers.id_dancer = $id_dancer
";

$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo json_encode(['error' => 'Dancer not found']);
    exit;
}

$row = mysqli_fetch_assoc($result);

// Получаем стили танцора
$style_query = "
    SELECT styles.id_style, styles.name_style
    FROM styles
    INNER JOIN dancer_style ON styles.id_style = dancer_style.id_style
    WHERE dancer_style.id_dancer = $id_dancer
";
$style_result = mysqli_query($connect, $style_query);
$styles = [];
while ($style = mysqli_fetch_assoc($style_result)) {
    $styles[] = [
        'id' => $style['id_style'],
        'name' => $style['name_style']
    ];
}

// Получаем команды танцора
$team_query = "
    SELECT teams.id_team, teams.name_team
    FROM teams
    INNER JOIN dancer_team ON teams.id_team = dancer_team.id_team
    WHERE dancer_team.id_dancer = $id_dancer
";
$team_result = mysqli_query($connect, $team_query);
$teams = [];
while ($team = mysqli_fetch_assoc($team_result)) {
    $teams[] = [
        'id' => $team['id_team'],
        'name' => $team['name_team']
    ];
}

// Получаем студии танцора
$studio_query = "
    SELECT studios.id_studio, studios.name_studio
    FROM studios
    INNER JOIN dancer_studio ON studios.id_studio = dancer_studio.id_studio
    WHERE dancer_studio.id_dancer = $id_dancer
";
$studio_result = mysqli_query($connect, $studio_query);
$studios = [];
while ($studio = mysqli_fetch_assoc($studio_result)) {
    $studios[] = [
        'id' => $studio['id_studio'],
        'name' => $studio['name_studio']
    ];
}

// Собираем все данные
$dancer = [
    'id' => $row['id_dancer'],
    'name' => $row['name_dancer'],
    'about' => $row['about_dancer'],
    'link' => $row['link_dancer'],
    'photo' => $row['photo_dancer'],
    'city_id' => $row['city_dancer'], // id города (важно для установки выбранного option)
    'city_name' => $row['name_city'], // просто для информации
    'is_teacher' => $row['is_teacher'],
    'styles' => $styles,
    'teams' => $teams,
    'studios' => $studios
];

// Возвращаем JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'dancer' => [
        'id_dancer' => $dancer['id'],
        'name_dancer' => $dancer['name'],
        'photo_dancer' => $dancer['photo'],
        'about_dancer' => $dancer['about'],
        'link_dancer' => $dancer['link'],
        'id_city' => $dancer['city_id'],
        'country' => 'Moldova', // или что-то другое, если нужно
        'teams' => $dancer['teams'],
        'studios' => $dancer['studios'],
        'styles' => $dancer['styles'],
        'is_teacher' => $dancer['is_teacher'],
    ]
]);
?>


