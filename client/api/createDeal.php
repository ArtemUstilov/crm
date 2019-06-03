<?php

if (!isset($_POST['login'], $_POST['password'], $_POST['vg_sum'], $_POST['debt'])) {
    echo array('status' => 'failed', 'error' => 'empty');
    return false;
}
include_once './funcs.php';
include_once '../../db.php';


session_start();
$login = clean($_POST['login']);
$debt = clean($_POST['debt']);
$sum_vg = clean($_POST['sum_vg']);
$password = clean($_POST['password']);
$sum_vg = clean($_POST['vg_sum']);
$vg_id = $_SESSION['vg_id'];
$vg_type_name = $_SESSION['vg_type'];
$fiat_id = $_SESSION['fiat_id'];

$user_id = mysqli_fetch_array($connection->
query("SELECT user_id FROM users 
       WHERE user_id IN 
       (SELECT user_id FROM clients WHERE login = '$login')"))['user_id'];

$vg_id = mysqli_fetch_assoc($connection->query("SELECT * FROM virtualgood WHERE vg_name = '$vg_type_name'"))['vg_id'];

$client_id = mysqli_fetch_array($connection->
query("SELECT client_id FROM clients WHERE login = '$login' AND password = '$password'"))['client_id'];
if (isset($client_id, $user_id)) {
    $order_info = mysqli_fetch_array($connection->
    query("SELECT order_id, real_out_percent, IFNULL(callmaster,0) AS 'callmaster', `loginByVg` FROM orders  
                  WHERE client_id = '$client_id' AND vg_id = '$vg_id' ORDER BY date DESC LIMIT 1"));
    if (!$order_info) {
        echo json_encode(array("status" => "failed", "error" => "REQUEST_FAILED"));
        return false;
    }
    $order_id = $order_info['order_id'];
    $loginByVG = $order_info['loginByVg'];
    $callmaster = $order_info['callmaster'];
    $out = $order_info['real_out_percent'];
    if ($debt) {
        $max_debt = mysqli_fetch_assoc($connection->
        query("SELECT `max_debt` FROM `clients` WHERE `client_id` = '$client_id' "))['max_debt'];
        if ((int)$sum_vg * (int)$out > (int)$max_debt) {
            json_encode(array("status" => "failed", "error" => "MAX_DEBT_EXCEEDED"));
            return false;
        }
    }
    $shares = mysqliToArray($connection->
    query("SELECT user_as_owner_id AS 'owner_id', share_percent AS 'value' FROM shares
                  WHERE order_id = '$order_id'"));
    $data = array("client" => $client_id, "user_id" => $user_id, "sum_vg" => $sum_vg,
        "fiat" => $fiat_id, "vg" => $vg_id, "obtain" => "платежка", "callmaster" => $callmaster,
        "shares" => json_encode($shares), "out" => $out, "loginByVg" => $loginByVG);
    $url = "https://" . $_SERVER['SERVER_NAME'] . "/components/modal-response/addOrder.php";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $out = curl_exec($curl);
    curl_close($curl);
    if ($out == 'empty' || $out == 'failed') {

        echo json_encode(array("status" => "failed", "error" => "NU_SUCH_CLIENT"));
        return false;
    }
    echo json_encode(array("status" => "success"));
    return false;

}
echo json_encode(array("status" => "failed", "error" => "NU_SUCH_CLIENT"));
return false;