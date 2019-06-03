<?php

if (!isset($_GET['login'], $_GET['password'])) {
    echo array('status' => 'failed', 'error' => 'empty');
    return false;
}
include_once '../../db.php';
include_once './funcs.php';
$login = clean($_GET['login']);
$password = clean($_GET['password']);

$exists = mysqli_fetch_assoc($connection->query(" SELECT * FROM clients WHERE login = '$login' AND `password` = '$password'"));
$client_id = $exists['client_id'];

$vgs = mysqliToArray($connection->query("
    SELECT * 
    FROM vg_data D
    INNER JOIN virtualgood V ON V.vg_id = D.vg_id
    WHERE D.vg_id IN (
        SELECT vg_id FROM orders WHERE client_id = '$client_id'
    )
"));

if ($exists) {
    $_SESSION['client_id'] = $exists['client_id'];
    echo json_encode(array("status" => "success", "vgs" => $vgs));
} else {
    echo json_encode(array("status" => "failed", "error" => "wrong params"));
}
