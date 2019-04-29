<?php
include_once '../../dev/ChromePhp.php';

if (isset($_POST['client']) &&
    isset($_POST['sum_vg']) &&
    isset($_POST['out']) &&
    isset($_POST['obtain']) &&
    isset($_POST['vg']) &&
    isset($_POST['shares'])) {

    include_once("../../bd/index.php");
    include_once("../../funcs.php");

    $sum_vg = clean($_POST['sum_vg']);
    $vg = clean($_POST['vg']);
    $rollback_1 = $_POST['rollback_1'] ? clean($_POST['rollback_1']) : 0;
    $client = clean($_POST['client']);
    $rollback_2 = $_POST['rollback_2'] ? clean($_POST['rollback_2']) : 0;
    $rollback_sum = $sum_vg / 100 * ($rollback_1 + $rollback_2);
    ChromePhp::log("rollback: ", $rollback_sum);
    $obtain = clean($_POST['obtain']);
    $out_percent = clean($_POST['out']);
    $shares = $_POST['shares'];
    $debt = $_POST['debtCl'] ? (clean($_POST['debtCl']) * $out_percent) / 100 : 0;
    $sum_currency = ($sum_vg * $out_percent) / 100;
    $money_to_add = $sum_currency - $debt;
    $date = date('Y-m-d H:i:s');

    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($mysql_connect->query("
        SELECT * 
        FROM users 
        WHERE user_id='$user_id'
    "));
    if ($user_data['role'] == 'admin' || $user_data['role'] == 'sub_admin' || $user_data['role'] == 'manager'
        || $user_data['role'] == 'moder') {
        $add_order = $mysql_connect->
        query("INSERT INTO `orders`
        (`vg_id`, `client_id`, `user_id`, `sum_vg`, `real_out_percent`, `sum_currency`, `method_of_obtaining`, `rollback_sum`, `rollback_1`, `rollback_2`, `date`) 
        VALUES
        ('$vg','$client', '$user_id', '$sum_vg','$out_percent','$sum_currency', '$obtain','$rollback_sum','$rollback_1','$rollback_2','$date') ");
        if ($add_order) {
            $in_percent = mysqli_fetch_assoc($mysql_connect->query("
            SELECT in_percent
            FROM virtualgood
            WHERE vg_id = '$vg'
            "))['in_percent'];

            $order_id = mysqli_fetch_assoc($mysql_connect->query("
            SELECT order_id
            FROM orders
            ORDER BY `date` DESC
            LIMIT 1
            "))['order_id'];

            foreach ($shares as $key => $var) {
                $sum_of_owner = (($out_percent - $in_percent - $rollback_1 - $rollback_2) / 100) * ($sum_vg * ($var['value'] / 100));
                //ChromePhp::log(" out: ", $out_percent," in: ", $out_percent," roll_1: ", $rollback_1," roll_2: ", $rollback_2," sum: ", $sum_vg," percent: ", $shares);
                ChromePhp::log($order_id, ' ', $var['owner_id'], '  ', $sum_of_owner, '  ', $var['value'], '  ');
                $curr_owner_id = $var['owner_id'];
                $share_percent = $var['value'];
                $add_share = $mysql_connect->
                query("INSERT INTO `shares`
                (`order_id`, `owner_id`, `sum`, `share_percent`) VALUES
                ('$order_id','$curr_owner_id','$sum_of_owner','$share_percent') ");
                ChromePhp::log("succes: ", $add_share);

            }
            if ($debt > 0) {
                $mysql_connect->
                query("UPDATE `clients` 
                             SET `debt` = `debt` + $debt 
                             WHERE `client_id` = '$client'");
            }
            if ($rollback_sum > 0) {
                $callmaster_id = mysqli_fetch_assoc($mysql_connect->
                query("SELECT callmaster
                              FROM `clients`
                              WHERE `client_id` = $client"))['callmaster'];
                $mysql_connect->
                query("UPDATE `clients` 
                             SET `rollback_sum` = `rollback_sum` + $rollback_sum
                             WHERE `client_id` = '$callmaster_id'");
            }
            if ($money_to_add > 0) {
                $mysql_connect->
                query("UPDATE `users` 
                             SET `money` = `money` + $money_to_add
                             WHERE `user_id` = '$user_id'");
                $_SESSION['money'] += $money_to_add;
            }
            echo "success";
            return false;
        } else {
            echo "failed";
            return false;
        }
        // TODO add order to DB
        // count all attributes
        // 1. Add order to orders
        // 2. Add all shares to shares
        // 3. Update client`s debt
        // 4. Update client`s rollback (callmaster)
        // 5. Update user`s money
        // 6. Update user`s money in session
        //
        // Last. reload page
    }
    echo "denied";
    return false;
} else {
    echo "empty";
}
