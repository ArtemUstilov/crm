<?php
if (isset($_POST['number']) && isset($_POST['login'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");

    $login = clean($_POST['login']);
    $number = clean($_POST['number']);
    $fiat = clean($_POST['fiat']);
    $client_data = mysqli_fetch_assoc($connection->query("SELECT * FROM clients WHERE byname='$login'"));
    $client_id = $client_data['client_id'];
    session_start();
    $branch_id = $_SESSION['branch_id'];
    $date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && heCan($user_data['role'], 1)) {

        $change_rollback_sum = $connection->query("
            UPDATE `payments` 
            SET `sum` = `sum` - $number 
            WHERE `client_rollback_id` = $client_id AND fiat_id = $fiat
        ");
        if($change_rollback_sum){
            $add_ref = $connection->
            query("INSERT INTO rollback_paying (user_id, client_id, rollback_sum, date, fiat_id) VALUES(\"$user_id\",\"$client_id\",\"$number\",\"$date\", '$fiat') ");
        }
        if ($add_ref) {
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