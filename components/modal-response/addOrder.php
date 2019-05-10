<?php
if (isset($_POST['client']) &&
    isset($_POST['sum_vg']) &&
    isset($_POST['out']) &&
    isset($_POST['obtain']) &&
    isset($_POST['vg']) &&
    isset($_POST['fiat']) &&
    isset($_POST['shares'])) {

    include_once("../../db.php");
    include_once("../../funcs.php");
    $sum_vg = clean($_POST['sum_vg']);
    $vg = clean($_POST['vg']);
    $rollback_1 = $_POST['rollback_1'] ? clean($_POST['rollback_1']) : 0;
    $client = clean($_POST['client']);
    $callmaster = $_POST['callmaster'];
    $description = $_POST['descr'];
    $rollback_sum = $sum_vg / 100 * ($rollback_1);
    $obtain = clean($_POST['obtain']);
    $out_percent = clean($_POST['out']);
    $shares = $_POST['shares'];
    $debt = $_POST['debtCl'] ? clean($_POST['debtCl']) : 0;
    $sum_currency = ($sum_vg * $out_percent) / 100;
    $money_to_add = $sum_currency - $debt;
    $date = date('Y-m-d H:i:s');
    $fiat = clean($_POST['fiat']);


    session_start();
    $user_id = $_SESSION['id'];
    $branch_id = $_SESSION['branch_id'];
    $user_data = mysqli_fetch_assoc($connection->query("
        SELECT * 
        FROM users 
        WHERE user_id='$user_id'
    "));
    if (heCan($user_data['role'], 1)) {
        if ($callmaster) {
            $add_order = $connection->
            query("INSERT INTO `orders`
        (`vg_id`, `client_id`, `sum_vg`, `real_out_percent`, `sum_currency`, `method_of_obtaining`, `rollback_sum`, `rollback_1`, `date`, `callmaster`, `order_debt`, `description`, `fiat_id`) 
        VALUES
        ('$vg', '$client', '$sum_vg', '$out_percent', '$sum_currency','$obtain', '$rollback_sum', '$rollback_1', '$date', '$callmaster', '$debt', '$description', '$fiat') ");
        } else {
            $add_order = $connection->
            query("INSERT INTO `orders`
        (`vg_id`, `client_id`, `sum_vg`, `real_out_percent`, `sum_currency`, `method_of_obtaining`, `rollback_sum`, `rollback_1`, `date`, `order_debt`, `description`, `fiat_id`) 
        VALUES
        ('$vg', '$client', '$sum_vg', '$out_percent', '$sum_currency','$obtain', '$rollback_sum', '$rollback_1', '$date', '$debt', '$description', '$fiat') ");
        }
        if ($add_order) {
            $in_percent = mysqli_fetch_assoc($connection->query("
            SELECT in_percent
            FROM vg_data
            WHERE vg_id = '$vg' AND branch_id = '$branch_id'
            "))['in_percent'];

            $order_id = mysqli_fetch_assoc($connection->query("
            SELECT order_id
            FROM orders
            ORDER BY `date` DESC
            LIMIT 1
            "))['order_id'];

            // TODO fix last_order
            foreach ($shares as $key => $var) {
                $sum_of_owner = (($out_percent - $in_percent - $rollback_1) / 100) * ($sum_vg * ($var['value'] / 100));
                $curr_owner_id = $var['owner_id'];
                $share_percent = $var['value'];
                $add_share = $connection->
                query("INSERT INTO `shares`
                (`order_id`, `user_as_owner_id`, `sum`, `share_percent`) VALUES
                ('$order_id','$curr_owner_id','$sum_of_owner','$share_percent') ");
            }
            if ($debt > 0) {
                $connection->
                query("UPDATE `clients` 
                             SET `debt` = `debt` + $debt 
                             WHERE `client_id` = '$client'");
            }
            if ($rollback_sum > 0) {
                $connection->
                query("UPDATE `clients` 
                             SET `rollback_sum` = `rollback_sum` + $rollback_sum
                             WHERE `client_id` = '$callmaster'");
            }
            if ($money_to_add > 0) {
                $connection->
                query("UPDATE `branch` 
                             SET `money` = `money` + $money_to_add
                             WHERE `branch_id` = '$branch_id'");
                $_SESSION['money'] += $money_to_add;
            }

            $vg_url = mysqli_fetch_assoc($connection->query("
                SELECT api_url_regexp
                FROM vg_data
                WHERE vg_id = '$vg'
            "))['api_url_regexp'];
            $client_login = mysqli_fetch_assoc($connection->query("
                SELECT byname
                FROM clients
                WHERE client_id = '$client'
            "))['byname'];
            //"http://nit.tron.net.ua/api/category/list/ttt" - test FAIL
            //'http://nit.tron.net.ua/api/category/list' - test SUCCESS
            $vg_url = str_replace("%UserName%", $client_login, "http://nit.tron.net.ua/api/category/list/ttt");
            $vg_url = str_replace("%Summ%", $sum_vg, $vg_url);

            set_error_handler(
                function ($severity, $message, $file, $line) {
                    throw new ErrorException($message, $severity, $severity, $file, $line);
                }
            );

            try {
                $result = file_get_contents($vg_url);
            } catch (Exception $e) {
                $response['url'] = $vg_url;
                $response['sent'] = false;
                echo json_encode($response);
                return false;
            }

            restore_error_handler();
            echo "success";
            return false;
        } else {
            echo "failed";
            return false;
        }

    }
    echo "denied";
    return false;
} else {
    echo "empty";
}
