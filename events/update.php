<?php
// Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');

// Include database and model
include_once '../config/Database.php';
include_once '../models/Event.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

// Instantiate event object
$event = new Event($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Validate ID
if (!empty($data->id) && !empty($data->title)) {
    $event->id = $data->id;
    $event->title = $data->title;
    $event->description = $data->description ?? '';
    $event->date = $data->date;
    $event->location = $data->location ?? '';

    // Update event
    if ($event->update()) {
        http_response_code(200); // OK
        echo json_encode(['message' => 'Event updated']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to update event']);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Event ID and title are required']);
}