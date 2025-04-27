<?php
require_once __DIR__ . '/../classes/FoundItem.php';
$item = new FoundItem();

$user_id = $_POST['user_id']?? '';
$item_id = $_POST['item_id']?? '';
$location = $_POST['location']?? '';
$description = $_POST['desc']?? '';

if($item->isMarked($user_id,$item_id))
{
    echo "<script>
    alert('You already Marked it');
    window.location.href = 'dashboard.php';
</script>";
exit;

}
$result=$item->postFoundItem($user_id,$description,$location,$item_id);
if(!$result)
{
    echo "Error";
}
else{
    echo "<script>
    alert('Found claim initiated');
    window.location.href = 'dashboard.php';
</script>";
exit;

}

?>