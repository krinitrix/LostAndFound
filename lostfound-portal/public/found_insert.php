<?php
require_once __DIR__ . '/../classes/FoundItem.php';
$item = new FoundItem();

$user_id = $_POST['user_id']?? '';
$item_id = $_POST['item_id']?? '';
$location = $_POST['location']?? '';
$description = $_POST['desc']?? '';

$result=$item->postFoundItem($user_id,$description,$location,$item_id);
if(!$result)
{
    echo "Error";
}
else{
    echo "Suscces";
}

?>