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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding-top: 50px;
        }

        form {
            background-color: #fff;
            display: inline-block;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="email"],
        input[type="password"] {
            width: 250px;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #load-anim {
            margin-top: 20px;
        }

        .loading-message {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
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
<br>
    <label for="register"><a href="register.php">Not have an account ? Register here</a></label>

    <?php if ($showLoading): ?>
    <div id="load-anim">
        <img src="../assets/images/loading.gif" alt="Logging in..." width="100" height="100">
        <div class="loading-message">Logging you in... Please wait</div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "<?php echo $redirectUrl; ?>";
        }, 500);
    </script>
    <?php endif; ?>
</body>
</html>
