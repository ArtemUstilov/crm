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
    ChromePhp::log("rollback: ",$rollback_sum);
    $obtain = clean($_POST['obtain']);
    $out_percent = clean($_POST['out']);
    $shares = $_POST['shares'];
    $debt = $_POST['debtCl'] ? clean($_POST['debtCl']) : 0;
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
            $order_id++;

            foreach ($shares as $key => $var) {
                $sum_of_owner = (($out_percent - $in_percent - $rollback_1 - $rollback_2) / 100) * ($sum_vg * ($shares['value'] / 100));
                ChromePhp::log($order_id, ' ', $var['owner_id'], '  ', $sum_of_owner, '  ', $var['value'], '  ');
                $add_share = $mysql_connect->
                query("INSERT INTO `shares`
                (`order_id`, `owner_id`, `sum`, `share_percent`) VALUES
                ('$order_id','" . $var['owner_id'] . "','$sum_of_owner','" . $var['value'] . "') ");
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
                ChromePhp::log($callmaster_id , " call");
                ChromePhp::log($client , " client");
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


//        $res = mysqliToArray($mysql_connect->query("
//            INSERT INTO `users` (`login`,`pass_hash`,`first_name`,`last_name`,`role`,`branch_name`, `money`)
//            VALUES('$login','$password','$first_name','$last_name','$role','$branch','$money') "));
//        if ($res) {
//            echo "success";
//            return false;
//        } else {
//            echo "failed";
//            return false;
//        }
    }
    echo "denied";
    return false;
} else {
    echo "empty";
}
