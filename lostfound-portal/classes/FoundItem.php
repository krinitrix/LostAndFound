<?php
require_once __DIR__ . '/../config/database.php';

class FoundItem {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Post a new found item
    public function postFoundItem($user_id, $item_name, $description, $location_found, $date_found) {
        $stmt = $this->conn->prepare(
            "INSERT INTO found_items (user_id, item_name, description, location_found, date_found)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issss", $user_id, $item_name, $description, $location_found, $date_found);
        return $stmt->execute();
    }

    // Get all found items by a user
    public function getItemsByUser($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM found_items WHERE user_id = ? ORDER BY date_found DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get all found items (for admin or browsing)
    public function getAllItems() {
        $stmt = $this->conn->prepare("SELECT * FROM found_items ORDER BY date_found DESC");
        $stmt->execute();
        return $stmt->get_result();
    }

    // Match a found item to a lost item (optional helper)
    public function matchToLostItem($found_id, $item_id) {
        $stmt = $this->conn->prepare("UPDATE found_items SET matched_item_id = ? WHERE found_id = ?");
        $stmt->bind_param("ii", $item_id, $found_id);
        return $stmt->execute();
    }
}
