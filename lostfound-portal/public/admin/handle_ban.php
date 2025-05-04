<?php
require_once("../../classes/Admin.php");
$admin = new Admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id=$_POST['user_id'];
    $action=$_POST['action'];

    switch($action)
    {
        case 'ban':
            if($admin->banUser($user_id))
            {
                echo "<script>
    alert('Successfully Banned user');
    window.location.href = 'index.php';
</script>";
            }
            else{
                echo "<script>
    alert('Error occur . returning to dashboard');
    window.location.href = 'index.php';
</script>";
            }
            break;
        case 'unban':
            if($admin->unbanUser($user_id))
            {
                echo "<script>
                alert('Successfully Unbanned user');
                window.location.href = 'index.php';
            </script>";  
            }
            else{
                echo "<script>
    alert('Error occur . returning to dashboard');
    window.location.href = 'index.php';
</script>";
            }
            break;
        default:
        echo "<script>
        alert('Invalid action');
        window.location.href = 'index.php';
    </script>";

    }
    
}
?>