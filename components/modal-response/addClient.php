<?php
if (isset($_POST['description']) && isset($_POST['byname'])
    && isset($_POST['first_name']) && isset($_POST['last_name'])) {

    include_once("../../db.php");
    include_once("../../funcs.php");
    $debt = 0.0;
    $rollback_sum = 0.0;
    $byname = clean($_POST['byname']);
    $first_name = clean($_POST['first_name']);
    $last_name = clean($_POST['last_name']);
    $description = clean($_POST['description']);
    $telegram = clean($_POST['telegram']);
    $phone = clean($_POST['phone']);
    $max_debt = clean($_POST['max_debt']);
    $pass = clean($_POST['password']);
    $pay_page = $_POST['pay_page'] === "true" ? true : false;
    $payment_system = $_POST['payment_system'] === "true" ? true : false;
    $pay_in_debt = $_POST['pay_in_debt'] === "true" ? true : false;
    $email = isset($_POST['email']) ? clean($_POST['email']) : " ";
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    $client = true;
    $check_client = mysqli_fetch_assoc($connection->query("SELECT client_id AS `id` FROM clients WHERE byname='$byname'"));
    if ($check_client) {
        echo "exists";
        return false;
    }
    if ($user_data && heCan($user_data['role'], 1)) {
        $res = $connection->
        query("
        INSERT INTO clients (`user_id`, `last_name`, `first_name`, `byname`, `phone_number`, `email`, `description`, `telegram`, `login`, `password`, `pay_in_debt`, `payment_system`, `pay_page`, `max_debt`) 
        VALUES('$user_id', '$last_name','$first_name','$byname','$phone','$email','$description', '$telegram', '$byname', '$pass', '$pay_in_debt', '$payment_system', '$pay_page', '$max_debt') ");
        $lastid = mysqli_fetch_assoc($connection ->query('SELECT client_id AS `id` FROM clients ORDER BY client_id DESC LIMIT 1'))['id'];
        if ($res) {
            echo "success".$lastid;
            return false;
        } else {
            echo "failed";
            return false;
        }

    } else {
        echo "empty";
        return false;
    }
}else{
    echo "empty";
}
