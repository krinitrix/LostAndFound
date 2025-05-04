<?php
require_once __DIR__ . '/../config/database.php';

class Admin {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }
    //BAN
     public function banUser($user_id)
     {
        $stmt=$this->conn->prepare("UPDATE users SET banned= 1 WHERE user_id= ? ");
        $stmt->bind_param("i",$user_id);
        return($stmt->execute());
     }
     public function unbanUser($user_id)
     {
        $stmt=$this->conn->prepare("UPDATE users SET banned=0 WHERE user_id=?");
        $stmt->bind_param("i",$user_id);
        return($stmt->execute());
     }



    // Get all users
    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT user_id, name, email,banned, role FROM users WHERE role = 'student'");
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get all lost items
    public function getAllLostItems() {
        $stmt = $this->conn->prepare("SELECT * FROM lost_items ORDER BY date_lost DESC");
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get all found items
    public function getAllFoundItems() {
        $stmt = $this->conn->prepare("SELECT * FROM found_items ORDER BY date_found DESC");
        $stmt->execute();
        return $stmt->get_result();
    }

    // Match found item to lost item
    public function matchFoundToLost($found_id, $item_id) {
        $stmt = $this->conn->prepare("UPDATE found_items SET matched_item_id = ? WHERE found_id = ?");
        $stmt->bind_param("ii", $item_id, $found_id);
        return $stmt->execute();
    }

    // Close a lost item (mark as resolved)
    public function closeLostItem($item_id) {
        $stmt = $this->conn->prepare("UPDATE lost_items SET status = 'closed' WHERE item_id = ?");
        $stmt->bind_param("i", $item_id);
        return $stmt->execute();
    }

    // Delete a user
    public function deleteUser($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}
