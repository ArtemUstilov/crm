<?php
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    include_once("../../db.php");
    $data = mysqli_fetch_assoc($connection->query("SELECT * FROM users  WHERE user_id='$user_id'"));
    if (!$data['active'] || $_SESSION['login'] != $data['login']) {
        session_destroy();
        echo 'inactive';
        exit;
    } else {
        echo 'active';
        return false;
    }
}