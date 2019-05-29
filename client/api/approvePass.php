<?php
include_once '../../db.php';
$login = $_GET['login'];
$password = $_GET['password'];

$exists = mysqli_fetch_assoc($connection->query(" SELECT * FROM clients WHERE login = '$login' AND `password` = '$password'"));

if ($exists) {
    echo json_encode(array("status" => "ok"));
} else {
    echo json_encode(array("error" => "wrong params"));
}
