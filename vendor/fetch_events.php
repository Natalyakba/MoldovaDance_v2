<?php
$connect = mysqli_connect("localhost", "root", "", "dance_community");

$data = json_decode(file_get_contents("php://input"), true);

// Строим условия
$conditions = [];

if (!empty($data['dates'])) {
    $dates = array_map(fn($d) => "'" . mysqli_real_escape_string($connect, $d) . "'", $data['dates']);
    $conditions[] = "event_date IN (" . implode(',', $dates) . ")";
}
if (!empty($data['cities'])) {
    $cities = implode(',', array_map('intval', $data['cities']));
    $conditions[] = "event_city IN ($cities)";
}
if (!empty($data['types'])) {
    $types = implode(',', array_map('intval', $data['types']));
    $conditions[] = "event_type IN ($types)";
}
if (!empty($data['styles'])) {
    $styles = implode(',', array_map('intval', $data['styles']));
    $conditions[] = "id_event IN (
        SELECT id_event FROM event_style WHERE id_style IN ($styles)
    )";
}
if (!empty($data['dancers'])) {
    $dancers = implode(',', array_map('intval', $data['dancers']));
    $conditions[] = "id_event IN (
        SELECT id_event FROM event_dancer WHERE id_dancer IN ($dancers)
    )";
}

// Финальный запрос
$sql = "SELECT * FROM events";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY event_date ASC";

$result = mysqli_query($connect, $sql);

// Вывод
if (mysqli_num_rows($result) > 0) {
    while ($event = mysqli_fetch_assoc($result)) {
        echo "<div class='event'>";
        echo "<h3>" . htmlspecialchars($event['event_name']) . "</h3>";
        echo "<p>Date: " . $event['event_date'] . "</p>";
        echo "<p>City ID: " . $event['event_city'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No events found.</p>";
}
