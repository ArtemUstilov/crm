<?php
if (isset($_POST['number']) && isset($_POST['login'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");

    $login = clean($_POST['login']);
    $number = clean($_POST['number']);
    $client_data = mysqli_fetch_assoc($connection->query("SELECT * FROM clients WHERE byname='$login'"));
    $client_id = $client_data['client_id'];
    session_start();
    $date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && ($user_data['role'] == 'admin' || $user_data['role'] == 'sub_admin' || $user_data['role'] == 'moder'
            || $user_data['role'] == 'agent')) {
        $add_ref = $connection->
        query("INSERT INTO debt_history (user_id, client_id, debt_sum, date) VALUES(\"$user_id\",\"$client_id\",\"$number\",\"$date\") ");
        $change_debt = $connection->query("
            UPDATE `clients` 
            SET `debt` = `debt` - $number 
            WHERE `client_id` = $client_id");
        $change_user_sum = $connection->query("
            UPDATE `users` 
            SET `money` = `money` + $number 
            WHERE `user_id` = $user_id");
        $_SESSION['money'] += $number;
        if ($change_debt && $add_ref && $change_user_sum) {
            echo "success";
            return false;
        }else{
            echo "failed";
            return false;
        }
    } else {
        echo "denied";
        return false;
    }
} else {
    echo "failed";
    return false;
}