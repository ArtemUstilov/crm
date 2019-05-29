<?php
if (isset($_POST['description']) && isset($_POST['byname'])
    && isset($_POST['first_name']) && isset($_POST['last_name'])) {

    include_once("../../db.php");
    include_once("../../funcs.php");
    $byname = clean($_POST['byname']);
    $first_name = clean($_POST['first_name']);
    $last_name = clean($_POST['last_name']);
    $description = clean($_POST['description']);
    $phone = clean($_POST['phone']);
    $debt = clean($_POST['debt']);
    $rollback = clean($_POST['rollback']);
    $email = isset($_POST['email']) ? clean($_POST['email']) : " ";
    $edit_client_id = clean($_POST['client_id']);
    $telegram = clean($_POST['telegram']);
    $pass = (int)clean($_POST['password']);
    $max_debt = clean($_POST['max_debt']);
    $pay_page = $_POST['pay_page'] === "true" ? true : false;
    $payment_system = $_POST['payment_system'] === "true" ? true : false;
    $pay_in_debt = $_POST['pay_in_debt'] === "true" ? true : false;
    session_start();
    $user_id = $_SESSION['id'];
    if(mysqli_fetch_assoc($connection->query("SELECT * FROM clients WHERE ((login = '$byname' AND login IS NOT NULL) || `password` = '$pass') AND client_id != '$edit_client_id'"))){
        echo "exists";
        return;
    }
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && (heCan($user_data['role'], 2))) {
        $res = $connection->
        query("
        UPDATE `clients` 
        SET `byname`='$byname',
            `first_name` = '$first_name',
            `last_name` = '$last_name',
            `phone_number` = '$phone',
            `email` = '$email', 
            `telegram` = '$telegram',
            `description` = '$description',
            `password` = '$pass',
            `login` = '$byname',
            `pay_in_debt`='$pay_in_debt',
            `payment_system`='$payment_system',
            `pay_page` = '$pay_page',
            `max_debt` = '$max_debt'
        WHERE `client_id` = '$edit_client_id'");
        if ($res) {
            echo "edit-success";
            return false;
        } else {
            echo "failed";
            return false;
        }

    } else {
        echo "empty";
        return false;
    }
}
