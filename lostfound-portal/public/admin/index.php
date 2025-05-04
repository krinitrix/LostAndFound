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
while ($users = $result->fetch_assoc()) {
    $banStatus=$users['banned'];
    $btn=($banStatus===1)?"<button class'unban'>Unban</button>":"<button class'ban'>Ban User</button>";

    echo "  
        <tr>
            <td>".$users['name']."</td>
            <td>".$users['email']."</td>
            <td>".$users['role']."</td>
            <td>".$btn."</td>
        </tr>";
}
echo "</table>";



?>