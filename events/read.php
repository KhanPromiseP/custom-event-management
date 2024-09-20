<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include database and model
include_once '../config/Database.php';
include_once '../models/Event.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

// Instantiate event object
$event = new Event($db);

// Checking if the id is set in the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Fetch event(s)
$stmt = $event->read($id);
$num = $stmt->rowCount();

if ($num > 0) {
    $events_arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $event_item = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'location' => $location
        ];
        array_push($events_arr, $event_item); //pushing each eventitemin to the events_arr
    }
    http_response_code(200); // OK
    echo json_encode($events_arr);
} else {
    http_response_code(404); // Not Found
    echo json_encode(['message' => 'No event found']);
}