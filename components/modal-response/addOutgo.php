<?php
if (isset($_POST['sum'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $sum = clean($_POST['sum']);
    $owner = clean($_POST['owner']);
    $descr = clean($_POST['description']);
    session_start();
    date_default_timezone_set('Europe/Kiev');
    $date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['id'];
    if($owner){
        $res = $connection->
        query("INSERT INTO `outgo` (`user_id`,`sum`,`owner_id`, `date`, `description`) VALUES('$user_id','$sum','$owner', '$date', '$descr') ");
    }else{
        $res = $connection->
        query("INSERT INTO `outgo` (`user_id`,`sum`, `date`, `description`) VALUES('$user_id','$sum', '$date', '$descr') ");
    }
    $_SESSION['money'] -= $sum;
    if ($res) {
        echo "success";
        return false;
    } else {
        echo "failed";
        return false;
    }
} else {
    echo "empty";
}
