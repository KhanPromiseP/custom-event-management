<?php
// Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

// Include database and model
include_once '../config/Database.php';
include_once '../models/Event.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

// Instantiating event object
$event = new Event($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Validating the required fields
if (!empty($data->title) && !empty($data->date)) {
    $event->title = $data->title;
    $event->description = $data->description ?? '';
    $event->date = $data->date;
    $event->location = $data->location ?? '';

    // Create event
    if ($event->create()) {
        http_response_code(201); // indicates event Created
        echo json_encode(['message' => 'Event created successfully']);
    } else {
        http_response_code(500); // For internal Server Error
        echo json_encode(['message' => 'Failed to create event']);
    }
} else {
    http_response_code(400); // For Bad Request
    echo json_encode(['message' => 'Title and date are required']);
}