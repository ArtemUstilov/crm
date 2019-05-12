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
    session_start();
    $user_id = $_SESSION['id'];
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
            `description` = '$description'
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
