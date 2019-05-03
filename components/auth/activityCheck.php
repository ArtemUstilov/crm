<?php
session_start();
if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    include_once("../../db.php");
    $data = mysqli_fetch_assoc($connection->query("SELECT active FROM users  WHERE user_id='$user_id'"));
    if ($data['active']) {
        echo 'active';
        return false;
    } else {
        session_destroy();
        echo 'inactive';
        exit;
    }
}