<?php
session_start();
if (isset($_SESSION['id'])) {

    $user_id = $_SESSION['id'];
    $old_money = $_SESSION['money'];
    $branch_id = $_SESSION['branch_id'];
    include_once("../../db.php");
    $money = mysqli_fetch_assoc($connection->query("SELECT money FROM branch  WHERE branch_id='$branch_id'"))['money'];
    if ($money != $old_money) {
        $_SESSION['money'] = $money;
        $res['money'] = $money;
    }
    $data = mysqli_fetch_assoc($connection->query("SELECT * FROM users  WHERE user_id='$user_id'"));
    if (!$data['active'] || $_SESSION['login'] != $data['login']) {
        session_destroy();
        $res['active'] = 'inactive';
        echo json_encode($res);
        exit;
    } else {
        $res['active'] = 'active';
        echo json_encode($res);
        return false;
    }
}