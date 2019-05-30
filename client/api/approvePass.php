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

if ($exists) {
    $_SESSION['client_id'] = $exists['client_id'];
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "failed", "error" => "wrong params"));
}
