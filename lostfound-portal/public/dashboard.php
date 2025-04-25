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
</head>
<body>
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

    <h3>Your Found Items</h3>
    <a href="post_found.php">+ Report Found Item</a><br><br>
    <ul>
        <?php while ($item = $myFoundItems->fetch_assoc()): ?>
            <li>
                <strong><?php echo htmlspecialchars($item['item_name']); ?></strong>
            </li>
        <?php endwhile; ?>
    </ul>

    <h3>All Reported Lost Items</h3>
<ul>
    <?php while ($item = $allLostItems->fetch_assoc()): ?>
        <li>
            <strong><?php echo htmlspecialchars($item['item_name']); ?></strong> 
            - Lost at: <?php echo htmlspecialchars($item['location_lost']); ?> 
            on <?php echo htmlspecialchars($item['date_lost']); ?> 
            (Status: <?php echo htmlspecialchars($item['status']); ?>)
            <br>
            description: <?php echo htmlspecialchars($item['description']); ?>)
            <?php if ($item['status'] === 'lost'): ?>
                <form method="post" action="mark_found.php" style="display:inline;">
                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                    <button type="submit">Mark as Found</button>
                </form>
            <?php endif; ?>
        </li>
    <?php endwhile; ?>
</ul>
</body>
</html>

