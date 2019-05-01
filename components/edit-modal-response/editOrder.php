<?php
if (isset($_POST['order_id']) &&
    isset($_POST['client_id']) &&
    isset($_POST['sum_vg']) &&
    isset($_POST['out']) &&
    isset($_POST['obtain']) &&
    isset($_POST['vg_id']) &&
    isset($_POST['shares']) &&
    isset($_POST['callmaster']) &&
    isset($_POST['client_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    include_once "../../dev/ChromePhp.php";
    ChromePhp::log($_POST);
    $rollback_1 = isset($_POST['rollback_1']) ? clean($_POST['rollback_1']) : 0;
    $rollback_2 = isset($_POST['rollback_2']) ? clean($_POST['rollback_2']) : 0;

    $vg_id = clean($_POST['vg_id']);
    $order_id = clean($_POST['order_id']);
    $client_id = clean($_POST['client_id']);
    $sum_vg = clean($_POST['sum_vg']);
    $out_percent = clean($_POST['out']);
    $debt = isset($_POST['debt']) ? clean($_POST['debt']) : 0;
    $callmaster = clean($_POST['callmaster']);
    $obtain = clean($_POST['obtain']);
    $rollback_sum = $sum_vg / 100 * ($rollback_1 + $rollback_2);
    $sum_currency = ($sum_vg * $out_percent) / 100;

    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && ($user_data['role'] == "admin" || $user_data['role'] == "moder")) {
        $order_data = mysqli_fetch_assoc($connection->
        query("SELECT *
                     FROM orders
                     WHERE order_id ='$order_id'"));
        if ($order_data['client_id'] != $client_id) {
            $old_client = $order_data['client_id'];
            $old_debt = $order_data['order_debt'];

            $update_old_client = $connection->
            query("UPDATE clients SET `debt` = `debt` - '$old_debt'
                     WHERE `client_id` = '$old_client'");

            $update_client = $connection->
            query("UPDATE clients SET `debt` = `debt` + '$debt'
                     WHERE `client_id` = '$client_id'");

        } else if ($order_data['order_debt'] != $debt) {
            $new_debt = $order_data['order_debt'] > $debt ? -($order_data['order_debt'] - $debt) : $debt - $order_data['order_debt'];
            $update_debt = $connection->
            query("UPDATE clients SET `debt` = `debt` + '$new_debt'
                     WHERE `client_id` = $client_id");
        }

        if ($order_data['callmaster'] != $callmaster) {
            $old_callmaster = $order_data['callmaster'];
            $old_rollback = $order_data['rollback_sum'];

            $update_old_callmaster = $connection->
            query("UPDATE clients SET `rollback_sum` = `rollback_sum` - '$old_rollback'
                     WHERE `client_id` = '$old_callmaster'");

            $update_callmaster = $connection->
            query("UPDATE clients SET `rollback_sum` = `rollback_sum` + '$rollback_sum'
                     WHERE `client_id` = '$callmaster'");

        } else if ($order_data['rollback_sum'] != $rollback_sum) {
            $new_rollback = $order_data['rollback_sum'] > $rollback_sum ? -($order_data['rollback_sum'] - $rollback_sum) : $rollback_sum - $order_data['rollback_sum'];
            $update_rollback = $connection->
            query("UPDATE clients SET `rollback_sum` = `rollback_sum` + '$new_rollback'
                     WHERE `client_id` = $callmaster");
        }

        $res = $connection->
        query("UPDATE orders SET `vg_id` = '$vg_id',
                     `client_id` = '$client_id',`sum_vg` = '$sum_vg',`real_out_percent` = '$out_percent',
                     `sum_currency` = '$sum_currency',`order_debt` = '$debt',`method_of_obtaining` = '$obtain',
                     `rollback_sum` = '$rollback_sum',`rollback_1` = '$rollback_1',`rollback_2` = $rollback_2,
                     `callmaster` = '$callmaster'
                     WHERE `order_id` = $order_id");
        if ($res) {
            echo "success";
            return false;
        } else {
            echo "failed";
            return false;
        }

    } else {
        echo "denied";
        return false;

    }
}
echo "empty";
return false;
