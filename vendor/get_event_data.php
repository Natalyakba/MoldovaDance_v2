<?php
require_once '../config/connect.php';

header('Content-Type: application/json');

if (isset($_POST['event_id']) && !empty($_POST['event_id'])) {
    $event_id = (int)$_POST['event_id'];

    $query = "SELECT * FROM events WHERE id_event = $event_id";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $event_data = mysqli_fetch_assoc($result);

        $styles_query = "SELECT id_style FROM event_style WHERE id_event = $event_id";
        $styles_result = mysqli_query($connect, $styles_query);
        $event_styles = [];
        while ($row = mysqli_fetch_assoc($styles_result)) {
            $event_styles[] = $row['id_style'];
        }

        $dancers_query = "SELECT id_dancer FROM event_guest WHERE id_event = $event_id";
        $dancers_result = mysqli_query($connect, $dancers_query);
        $event_dancers = [];
        while ($row = mysqli_fetch_assoc($dancers_result)) {
            $event_dancers[] = $row['id_dancer'];
        }

        $org_query = "SELECT organizer_type, organizer_id FROM event_organizers WHERE id_event = $event_id";
        $org_result = mysqli_query($connect, $org_query);
        $event_organizers = [];
        while ($row = mysqli_fetch_assoc($org_result)) {
            $event_organizers[] = [
                'type' => $row['organizer_type'],
                'id' => $row['organizer_id']
            ];
        }

        echo json_encode([
            'success' => true,
            'event' => $event_data,
            'styles' => $event_styles,
            'dancers' => $event_dancers,
            'organizers' => $event_organizers
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Event not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
