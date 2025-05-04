<?php
require_once __DIR__ . '/../config/database.php'; // adjust path if needed
require_once __DIR__ . '/../classes/FoundItem.php';

$item=new FoundItem();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $item_id = $_POST['item_id'] ?? '';
    $found_id = $_POST['found_id'] ?? '';


    if (empty($item_id) || !in_array($action, ['approve', 'reject'])) {
        echo "Invalid request.";
        exit;
    }

    $db = (new database())->connect();

    if ($action === 'approve') {

        
        // Begin transaction
        $db->begin_transaction();

        try {
            $result=$item->setStatus($found_id,'found');
            // Delete from lost_items
            // $stmt1 = $db->prepare("DELETE FROM lost_items WHERE item_id = ?");
            // $stmt1->bind_param("i", $item_id);
            // $stmt1->execute();

            
            // Delete from found_items
            // $stmt2 = $db->prepare("DELETE FROM found_items WHERE found_id = ?");
            // $stmt2->bind_param("i", $found_id);


            // $stmt2->execute();

            $db->commit();
            echo "<script>
    alert('Claim Approved. Item is found!!');
    window.location.href = 'dashboard.php';
</script>";
        } catch (Exception $e) {
            $db->rollback();
            echo "<script>
    alert('Error');
    window.location.href = 'dashboard.php';
</script>"; 
        }
    } elseif ($action === 'reject') {
        // Just delete from found_items
        $stmt = $db->prepare("DELETE FROM found_items WHERE matched_item_id = ?");
        $stmt->bind_param("i", $item_id);
        if ($stmt->execute()) {
            echo "<script>
    alert('Claim Rejected');
    window.location.href = 'dashboard.php';
</script>";
        }elseif ($action==='delete'){




            
        }
         else {
            echo "<script>
    alert('Error Rejecting claim');
    window.location.href = 'dashboard.php';
</script>";
        }
    }
} else {
    echo "<script>
    alert('Something went wrongs');
    window.location.href = 'dashboard.php';
</script>";
}
?>
