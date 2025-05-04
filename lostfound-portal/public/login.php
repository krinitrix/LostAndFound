<?php
session_start();
require_once __DIR__ . '/../classes/User.php';

$message = "";
$showLoading = false;
$redirectUrl = ""; // initialize for later use

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = new User();
    $loginResult = $user->login($email, $password);

    if ($loginResult) {
        if ($loginResult['banned']) {
            $message = "You Are Banned";
        } else {
            $_SESSION['user_id'] = $loginResult['user_id'];
            $_SESSION['name'] = $loginResult['name'];
            $_SESSION['role'] = $loginResult['role'];

            $showLoading = true;
            $redirectUrl = ($loginResult['role'] === 'admin') ? "admin/.php" : "dashboard.php";
        }
    } else {
        $message = "Invalid email or password!";
    }
}
?>



<!-- Simple HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h2>Login</h2>

    <?php if ($message): ?>
        <p style="color:red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <label for="register"><a href="register.php">Register</a></label>

    <?php if ($showLoading): ?>
    <div id="load-anim">
        <img src="../assets/images/loading.gif" alt="Logging in..." width="100" height="100">
        <div class="loading-message">Logging you in... Please wait</div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "<?php echo $redirectUrl; ?>";
        }, 1000);
    </script>
    <?php endif; ?>
</body>
</html>
