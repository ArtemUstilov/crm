<?php
if (isset($_POST['sum'], $_POST['fiat'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $sum = clean($_POST['sum']);
    $owner = clean($_POST['owner']);
    $fiat = clean($_POST['fiat']);
    $descr = clean($_POST['description']);
    session_start();
    $branch_id = $_SESSION['branch_id'];
    date_default_timezone_set('Europe/Kiev');
    $date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['id'];
    if($owner == "branch"){
        $res = $connection->
        query("INSERT INTO `outgo` (`user_id`,`sum`, `date`, `description`, `fiat_id`, `branch_id`) VALUES('$user_id','$sum', '$date', '$descr', '$fiat', '$branch_id') ");
    }elseif($owner) {
        $res = $connection->
        query("INSERT INTO `outgo` (`user_id`,`sum`,`user_as_owner_id`, `date`, `description`, `fiat_id`) VALUES('$user_id','$sum','$owner', '$date', '$descr', '$fiat') ");

    }else{
        $res = $connection->
        query("INSERT INTO `outgo` (`user_id`,`sum`, `date`, `description`, `fiat_id`) VALUES('$user_id','$sum', '$date', '$descr', '$fiat') ");
    }
    if($res)
        updateBranchMoney($connection, $branch_id, -$sum, $fiat);
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
