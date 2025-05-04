<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logging out...</title>
    <style>
        #load-anim {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .loading-message {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body><div id=load-anim>
    <img src="../assets/images/loading.gif" alt="Logging out..." width="100" height="100">
    <div class="loading-message">Logging you out... Please wait</div>\
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "login.php";
        }, 2000); // 2 seconds delay
    </script>
</body>
</html>
