<?php
if (isset($_POST['sum'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $sum = clean($_POST['sum']);
    $owner = clean($_POST['owner']);
    $fiat = clean($_POST['fiat']);
    $descr = clean($_POST['description']);
    session_start();
    date_default_timezone_set('Europe/Kiev');
    $date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['id'];
    if($owner){
        $res = $connection->
        query("INSERT INTO `outgo` (`user_id`,`sum`,`user_as_owner_id`, `date`, `description`, `fiat_id`) VALUES('$user_id','$sum','$owner', '$date', '$descr', '$fiat') ");
    }else{
        $res = $connection->
        query("INSERT INTO `outgo` (`user_id`,`sum`, `date`, `description`, `fiat_id`) VALUES('$user_id','$sum', '$date', '$descr', '$fiat') ");
    }
    if($res)
       $money_update = $connection->
        query("UPDATE branch SET `money` = `money` - '$sum' WHERE branch_id IN(
                                                                     SELECT branch_id 
                                                                     FROM users
                                                                     WHERE user_id = '$user_id'
)");
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
