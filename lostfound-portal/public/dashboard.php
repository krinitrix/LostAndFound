<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../classes/LostItem.php';
require_once __DIR__ . '/../classes/FoundItem.php';

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

$lostItem = new LostItem();
$foundItem = new FoundItem();

$myLostItems = $lostItem->getItemsByUser($user_id);
$myFoundItems = $foundItem->getItemsByUser($user_id);

//edited code
$allLostItems = $lostItem->getAllOpenItems();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <!-- <link rel="stylesheet" href="../assets/css/dash_popup.css"> -->
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<!--popup-form -->
<div class="popup-overlay" id="popup">
  <div class="popup-container">
    <h2>Fill the details</h2>
    <form method=POST action=found_insert.php>
      <div>
        <input type="hidden" name="item_id" id="popup-item-id">
        <input type="hidden" name="user_id" value="<?php echo $user_id ?>" >

        <label for="location">Location Found:</label><br>
        <textarea id="location" name="location" placeholder="Where did you found the item?" rows="2" cols="30" required></textarea>
      </div>

      <div style="margin-top: 10px;">
        <label for="desc">Description:</label><br>
        <textarea id="desc" name="desc" placeholder="Description (optional)" rows="4" cols="30"></textarea>
      </div>

      <button type="submit" style="margin-top: 15px;">Submit</button>
    </form>
    <button style="margin-top:10px;" class="close-popup-btn" onclick="closePopup()">Close</button>
  </div>
</div>

  <!-- form end -->
   <div id="main-content">
    <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>

    <a href="logout.php">Logout</a>

    <h3>Your Lost Items</h3>
    <a href="post_lost.php">+ Report Lost Item</a><br><br>
    <ul>
        <?php while ($item = $myLostItems->fetch_assoc()): ?>
            <li>
                <strong><?php echo htmlspecialchars($item['item_name']); ?></strong> -
                Status: <?php echo $item['status']; ?>
            </li>
        <?php endwhile; ?>
    </ul>

  
    <div class="card">
                <div class="card-header">
                    <h2 class="card-title">All Reported Lost Items</h2>
                </div>
                
                <ul class="item-list">
                    <?php if ($allLostItems->num_rows > 0): ?>
                        <?php while ($item = $allLostItems->fetch_assoc()): ?>
                            <li class="item-card">
                            <div class="item-header">
    
    <div class="item-name">
        <strong>Item:</strong> <?php echo htmlspecialchars($item['item_name']); ?>
    </div>
    <div class="item-status 
        <?php if ($item['status'] === 'lost'): ?>status-lost
        <?php elseif ($item['status'] === 'pending'): ?>status-pending
        <?php elseif ($item['status'] === 'found'): ?>status-found
        <?php else: ?>status-rejected<?php endif; ?>">
        <?php 
            if ($item['status'] === 'pending') {
                echo 'Pending Confirmation';
            } else {
                echo ucfirst($item['status']);
            }
        ?>
    </div>
</div>

                                
                                <div class="item-details">
                                    Lost at: <?php echo htmlspecialchars($item['location_lost']); ?>
                                    on <?php echo htmlspecialchars($item['date_lost']); ?>
                                </div>
                                
                                <div class="item-description">
                                    <?php echo htmlspecialchars($item['description']); ?>
                                </div>
                                
                                <?php if ($item['status'] === 'lost'): ?>
                                    <button 
                                        type="button" 
                                        class="action-btn open-popup-btn" 
                                        data-item-id="<?php echo $item['item_id']; ?>" 
                                        onclick="openPopup(this)">
                                        Mark as Found
                                    </button>
                                    <div style="float:right;"><span style="font-size: 12px;font-style:italic;">posted by <strong><?php echo htmlspecialchars($item['name']); ?></strong></span>
                                <?php endif; ?>
                                
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>There are no lost items reported in the system.</p>
                        </div>
                    <?php endif; ?>
                </ul>
</div>
</body>
</html>

<script src="../assets/js/popup.js"></script>