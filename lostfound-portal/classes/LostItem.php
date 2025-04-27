<?php
require_once __DIR__ . '/../config/database.php';

class LostItem {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Post a new lost item
    public function postLostItem($user_id, $item_name, $description, $location_lost) {
        $stmt = $this->conn->prepare(
            "INSERT INTO lost_items (user_id, item_name, description, location_lost)
             VALUES (?, ?, ?, ?)"
        );
    
        if (!$stmt) {
            // If prepare fails, you can debug the SQL error
            die("Prepare failed: " . $this->conn->error);
        }
    
        $stmt->bind_param("isss", $user_id, $item_name, $description, $location_lost);
    
        return $stmt->execute();
    }
    

    // Get all lost items by a specific user
    public function getItemsByUser($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM lost_items WHERE user_id = ? ORDER BY date_lost DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get all open lost items (for searching and matching)
    public function getAllOpenItems() {
        $stmt = $this->conn->prepare("SELECT lost_items.*, users.name 
FROM lost_items 
JOIN users 
ON lost_items.user_id = users.user_id 
WHERE lost_items.status = 'lost' 
ORDER BY lost_items.date_lost DESC;
");
        $stmt->execute();
        return $stmt->get_result();
    }

    // Close a lost item (mark as resolved)
    public function closeItem($item_id) {
        $stmt = $this->conn->prepare("UPDATE lost_items SET status = 'closed' WHERE item_id = ?");
        $stmt->bind_param("i", $item_id);
        return $stmt->execute();
    }
}
