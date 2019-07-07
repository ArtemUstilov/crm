<?php
include_once '../../dev/ChromePhp.php';
if (isset($_POST['client']) &&
    isset($_POST['sum_vg']) &&
    isset($_POST['out']) &&
    isset($_POST['obtain']) &&
    isset($_POST['vg']) &&
    isset($_POST['fiat']) &&
    isset($_POST['shares']) &&
    isset($_POST['loginByVg'])) {

    include_once("../../db.php");
    include_once("../../funcs.php");


    $sum_vg = clean($_POST['sum_vg']);
    $login_by_vg = clean($_POST['loginByVg']);
    $vg = clean($_POST['vg']);
    $rollback_1 = $_POST['rollback_1'] ? clean($_POST['rollback_1']) : 0;
    $client = clean($_POST['client']);
    $callmaster = $_POST['callmaster'];
    $description = $_POST['descr'];
    $out_percent = clean($_POST['out']);

    $sum_currency = ($sum_vg * $out_percent) / 100;
    $rollback_sum = $sum_currency * $rollback_1 / 100;
    $obtain = clean($_POST['obtain']);

    $shares = is_array($_POST['shares']) ? $_POST['shares'] : json_decode($_POST['shares'], true);

    $debt = $_POST['debtCl'] ? clean($_POST['debtCl']) : 0;

    $money_to_add = $sum_currency - $debt;
    $date = date('Y-m-d H:i:s');
    $fiat = clean($_POST['fiat']);


    session_start();
    $user_id = $_POST['user_id'] ? $_POST['user_id'] : $_SESSION['id'];
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
        (`vg_id`, `client_id`, `sum_vg`, `real_out_percent`, `sum_currency`, `method_of_obtaining`, `rollback_sum`, `rollback_1`, `date`, `callmaster`, `order_debt`, `description`, `fiat_id`, `loginByVg`)
        VALUES
        ('$vg', '$client', '$sum_vg', '$out_percent', '$sum_currency','$obtain', '$rollback_sum', '$rollback_1', '$date', '$callmaster', '$debt', '$description', '$fiat', '$login_by_vg') ");
        } else {
            $add_order = $connection->
            query("INSERT INTO `orders`
        (`vg_id`, `client_id`, `sum_vg`, `real_out_percent`, `sum_currency`, `method_of_obtaining`, `rollback_sum`, `rollback_1`, `date`, `order_debt`, `description`, `fiat_id`, `loginByVg`)
        VALUES
        ('$vg', '$client', '$sum_vg', '$out_percent', '$sum_currency','$obtain', '$rollback_sum', '$rollback_1', '$date', '$debt', '$description', '$fiat', '$login_by_vg') ");
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
                $check_payment_debt = mysqliToArray($connection->
                query("SELECT * FROM payments
                              WHERE `fiat_id` = '$fiat' AND `client_debt_id` = '$client' "));
                if ($check_payment_debt)
                    $update_payments_debt = $connection->
                    query("UPDATE  `payments`
                                  SET `sum` = `sum` + '$debt'
                                  WHERE client_debt_id = '$client' AND `fiat_id` = '$fiat'");
                else
                    $insert_payments_debt = $connection->
                    query("INSERT INTO `payments`
                             (`fiat_id`, `sum`, `client_debt_id`)
                             VALUES('$fiat', '$debt', '$client') ");
            }
            if ($rollback_sum > 0) {

                $check_payment_rollback = mysqliToArray($connection->
                query("SELECT * FROM payments
                              WHERE `fiat_id` = '$fiat' AND `client_rollback_id` = '$callmaster' "));

                if ($check_payment_rollback)
                    $connection->
                    query("UPDATE  `payments`
                                  SET `sum` = `sum` + '$rollback_sum'
                                  WHERE client_rollback_id = '$callmaster' AND `fiat_id` = '$fiat'");
                else
                    $connection->
                    query("INSERT INTO `payments`
                             (`fiat_id`, `sum`, `client_rollback_id`)
                             VALUES('$fiat', '$rollback_sum', '$callmaster') ");
            }
            if ($money_to_add > 0) {
                updateBranchMoney($connection, $branch_id, $money_to_add, $fiat);
            }

            $vg_data = mysqli_fetch_assoc($connection->query("
                SELECT `api_url_regexp` AS `url`, access_key AS `key`
                FROM vg_data
                WHERE vg_id = '$vg'
            "));
            $client_login = mysqli_fetch_assoc($connection->query("
                SELECT `byname`
                FROM clients
                WHERE client_id = '$client'
            "))['byname'];
            //"http://nit.tron.net.ua/api/category/list/ttt" - test FAIL
            //'http://nit.tron.net.ua/api/category/list' - test SUCCESS
            $vg_url = strtolower($vg_data['url']);
            if (!isset($vg_url) || $vg_url == "" || $vg_url == " ") {
                echo "success";
                return false;
            }

            if (strpos($vg_url, '%clientlogin%') && strpos($vg_url, '%sum%') && strpos($vg_url, '/api/transfer/?tr=%idtransact%&key=')) {
                $IDTransact = generateRandomString();
                $vg_url = str_replace("%sum%", $sum_vg, $vg_url);
                $vg_url = str_replace("%idtransact%", $IDTransact, $vg_url);
                $vg_url = str_replace("%key%", $vg_data['key'], $vg_url);
                $vg_url = str_replace("%clientlogin%", $login_by_vg, $vg_url);
                $nMidApi = strpos($vg_data['url'], '/api/');

                $vg_url_4md5 = substr($vg_url, $nMidApi);
                ChromePhp::log("for md5: ", $vg_url_4md5);
                $md5 = md5($vg_url_4md5 . ":" . $vg_data['key']);

                $vg_url = $vg_url . "&sign=" . $md5;
            } else {
                $vg_url = str_replace("%clientlogin%", $login_by_vg, $vg_data['url']);
                $vg_url = str_replace("%sum%", $sum_vg, $vg_url);
            }
            set_error_handler(
                function ($severity, $message, $file, $line) {
                    throw new ErrorException($message, $severity, $severity, $file, $line);
                }
            );

            try {
                $result = json_decode(file_get_contents($vg_url));

                if ($result->{'success'} == false) {
                    $result->{'url'} = $vg_url;
                    echo json_encode($result);
                    return false;
                }
            } catch (Exception $e) {
                $response['url'] = $vg_url;
                $response['success'] = false;
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