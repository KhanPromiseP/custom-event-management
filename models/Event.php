<?php
class Event {
    private $conn;
    private $table = 'events';

    // Event properties
    public $id;
    public $title;
    public $description;
    public $date;
    public $location;


    public function __construct($db) {
        $this->conn = $db;
    }

    // Sanitize a single input
    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    // Sanitize the event data
    public function sanitizeData() {
        $this->title = $this->sanitizeInput($this->title);
        $this->description = $this->sanitizeInput($this->description);
        $this->date = $this->sanitizeInput($this->date);
        $this->location = $this->sanitizeInput($this->location);
    }

    // Creating event
    public function create() {
        $query = "INSERT INTO " . $this->table . " (title, description, date, location) VALUES (:title, :description, :date, :location)";
        $stmt = $this->conn->prepare($query);

        // Sanitize and bind data
        $this->sanitizeData();
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':location', $this->location);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Read all the events or a single event
    public function read($id = null) {
        if ($id) {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
        } else {
            $query = "SELECT * FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
        }

        $stmt->execute();
        return $stmt;
    }

    // Update an event
    
    public function update() {
        $query = "UPDATE " . $this->table . " SET title = :title, description = :description, date = :date, location = :location WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize and bind data
        $this->sanitizeData();
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':location', $this->location);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete an event
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Bind the id parameter
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}