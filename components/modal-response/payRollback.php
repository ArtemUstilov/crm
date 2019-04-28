<?php
if (isset($_POST['number']) && isset($_POST['login'])) {
    include_once("../../bd/index.php");
    include_once("../../funcs.php");

    $login = clean($_POST['login']);
    $number = clean($_POST['number']);
    $client_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM clients WHERE byname='$login'"));
    $client_id = $client_data['client_id'];
    session_start();
    $date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && ($user_data['role'] == 'admin' || $user_data['role'] == 'sub_admin' || $user_data['role'] == 'moder'
            || $user_data['role'] == 'manager')) {
        $add_ref = $mysql_connect->
        query("INSERT INTO rollback_paying (user_id, client_id, rollback_sum, date) VALUES(\"$user_id\",\"$client_id\",\"$number\",\"$date\") ");
        $change_rollback_sum = $mysql_connect->query("
            UPDATE `clients` 
            SET `rollback_sum` = `rollback_sum` - $number 
            WHERE `client_id` = $client_id
        ");
        $change_user_sum = $mysql_connect->query("
            UPDATE `users` 
            SET `money` = `money` - $number 
            WHERE `user_id` = $user_id");
        $_SESSION['money'] -= $number;
        if ($change_rollback_sum && $add_ref) {
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