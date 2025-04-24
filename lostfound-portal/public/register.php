<?php
session_start();
require_once __DIR__ . '/../classes/User.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = new User();
    $result = $user->register($name, $email, $password);

    if ($result) {
        $message = "Registration successful! You can now <a href='login.php'>login</a>.";
    } else {
        $message = "Registration failed. Email might already be used.";
    }
}
?>

<!-- HTML Part -->
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>User Registration</h2>

    <?php if ($message): ?>
        <p style="color: <?= strpos($message, 'successful') !== false ? 'green' : 'red' ?>;">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

    <form method="post" action="">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
