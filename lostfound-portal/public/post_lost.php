<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Lost Item</title>
    <link rel="stylesheet" href="../assets/css/post_lost_style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Report a Lost Item</h1>
            <a href="dashboard.php" class="back-link">
                <span class="back-icon">←</span> Back to Dashboard
            </a>
        </header>
        
        <div class="form-container">
            <?php if (isset($error)): ?>
                <div class="error-message" style="display: block;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="" id="lostItemForm">
                <div class="form-group">
                    <label for="item_name" class="required">Item Name</label>
                    <input type="text" name="item_name" id="item_name" required 
                           placeholder="What did you lose?" maxlength="100">
                    <span class="character-count" id="itemNameCount">0/100</span>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" 
                              placeholder="Color, size, identifying features, etc." maxlength="500"></textarea>
                    <span class="character-count" id="descriptionCount">0/500</span>
                </div>
                
                <div class="form-group">
                    <label for="location_lost" class="required">Location Lost</label>
                    <textarea name="location_lost" id="location_lost" rows="2" required
                              placeholder="Where do you remember last having it?" maxlength="200"></textarea>
                    <span class="character-count" id="locationCount">0/200</span>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn-primary">Submit Report</button>
                    <button type="reset" class="btn-secondary">Clear Form</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="../assets/js/char_counter.js"></script>
</body>
</html>
<?php
require_once __DIR__ . '/../classes/LostItem.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data directly
    $user_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $location_lost = $_POST['location_lost'];

    $lostItem= new LostItem();
    $res=$lostItem->postLostItem($user_id, $item_name, $description, $location_lost);
    if($res)
    {
        echo "<script>
        alert('Successfully reported the Item');
        window.location.href = 'dashboard.php';
    </script>";
    }
    else{
        echo "failed";
    }
}
