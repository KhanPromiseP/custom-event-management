<?php
// Headers 
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');

// Include database and model 
include_once '../config/Database.php';
include_once '../models/Event.php';


$database = new Database();
$db = $database->getConnection();

$event = new Event($db);

// Get ID from query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Validate the gotten ID
if (!empty($id)) {
    $event->id = $id;

    // Delete event
    if ($event->delete()) {
        http_response_code(200); // OK
        echo json_encode(['message' => 'Event deleted successfully']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to delete event']);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Event ID is required']);
}