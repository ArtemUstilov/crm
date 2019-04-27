<?php
if (isset($_POST['description']) && isset($_POST['byname'])
    && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone'])) {

    include_once("../../bd/index.php");
    include_once("../../funcs.php");
    $debt = 0.0;
    $rollback_sum = 0.0;
    $byname = clean($_POST['byname']);
    $first_name = clean($_POST['first_name']);
    $last_name = clean($_POST['last_name']);
    $description = clean($_POST['description']);
    $callmaster = clean($_POST['callmaster']);
    $callmaster = $callmaster != "Выберите пригласившего" ?: " ";
    $phone = clean($_POST['phone']);
    $email = isset($_POST['email']) ? clean($_POST['email']) : " ";
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE user_id='$user_id'"));
    $client = true;
    $check_client = mysqli_fetch_assoc($mysql_connect->query("SELECT client_id AS id FROM clients WHERE byname='$byname'"));
    if ($check_client) {
        echo "exists";
        return false;
    }
    if ($user_data && ($user_data['role'] == "admin" || $user_data['role'] == "sub-admin" || $user_data['role'] == "manager")) {
        if ($callmaster != " ") {
            $check_master = mysqli_fetch_assoc($mysql_connect->query("SELECT client_id AS id FROM clients WHERE byname='$callmaster'"));
            if ($check_master) {
                $callmaster = $check_master['id'];
            } else {
                echo "doesNotExist";
                return false;
            }
        }
        $res = $mysql_connect->
        query("INSERT INTO clients (last_name,first_name,byname,debt,rollback_sum,phone_number,email, description, callmaster ) VALUES(\"$last_name\",\"$first_name\",\"$byname\",0,0,\"$phone\",\"$email\",\"$description\",$callmaster) ");
        if ($res) {
            echo "success";
            return false;
        } else {
            echo "failed";
            return false;
        }

    } else {
        echo "empty";
        return false;
    }
    echo "denied";
    return false;
}
