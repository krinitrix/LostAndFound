<?php

require_once("../../config/database.php");
require_once("../../classes/Admin.php");

$conn=new Database();
$admin= new Admin();
$result=$admin->getAllUsers();

echo "<table BORDER=2>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Another Head</th>
            <th>Action</th>
        </tr>";

echo '
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="admin.css">';

while ($users = $result->fetch_assoc()) {
    $banStatus=$users['banned'];
    $btn=($banStatus===1)?"Unban":"Ban";

    echo "  
        <tr>
            <td>".$users['name']."</td>
            <td>".$users['email']."</td>
            <td>".$users['role']."</td>
            <td>
<form action=handle_ban.php method=post>            
            <button type=submit class=".strtolower($btn)."-button VALUE=".strtolower($btn)." name=action>".$btn."</button></td>
            <input type=hidden name=user_id value=".$users['user_id'].">
            
</form>
        </tr>";
}
echo "</table>";




?>
