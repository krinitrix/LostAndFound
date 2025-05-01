<?php
require_once __DIR__ . '/../config/database.php';

class FoundItem {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Post a new found item
    public function postFoundItem($user_id, $description, $location_found,$item_id) {
        $stmt = $this->conn->prepare(
            "INSERT INTO found_items (user_id, description, location_found,matched_item_id)
             VALUES (?, ?, ?,?)"
        );
        $stmt->bind_param("issi", $user_id,$description, $location_found, $item_id);
        return $stmt->execute();
    }

    // Get all found items by a user
    public function getItemsByUser($user_id) {
        $stmt = $this->conn->prepare("SELECT found_items.*, lost_items.item_name
        FROM found_items
        JOIN lost_items ON found_items.matched_item_id = lost_items.item_id
        WHERE found_items.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    //new function to get incomming calaims
    public function getIncomingClaims($ownerId) {
        $sql = "
      SELECT 
        f.found_id,
        f.matched_item_id,
        f.status,
        u.name          AS finder_name,
        u.email         AS finder_email,
        f.location_found,
        f.description,
        l.item_name
      FROM found_items AS f
      JOIN lost_items  AS l ON f.matched_item_id    = l.item_id
      JOIN users       AS u ON f.user_id    = u.user_id
      WHERE l.user_id = ?      -- only claims against *your* lost items
        AND f.status  = 'pending'
      ORDER BY f.found_id DESC
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $ownerId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get all found items (for admin or browsing)
    public function getAllItems() {
        $stmt = $this->conn->prepare("SELECT * FROM found_items ORDER BY date_found DESC");
        $stmt->execute();
        return $stmt->get_result();
    }
    public function isMarked ($user_id,$matched_item_id) {
        $stmt=$this->conn->prepare("SELECT * From found_items WHERE user_id= ? AND matched_item_id= ? ");
        $stmt->bind_param("ii",$user_id,$matched_item_id);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->num_rows > 0;
       

        
    }

    // Match a found item to a lost item (optional helper)
    public function matchToLostItem($found_id, $item_id) {
        $stmt = $this->conn->prepare("UPDATE found_items SET matched_item_id = ? WHERE found_id = ?");
        $stmt->bind_param("ii", $item_id, $found_id);
        return $stmt->execute();
    }
}
