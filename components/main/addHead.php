<?php
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['branch'])) {
    include_once("../../bd/index.php");
    include_once("../../funcs.php");
    $name = clean($_POST['name']);
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && ($user_data['role'] == "admin" || $user_data['role'] == "sub-admin" || $user_data['role'] == "manager")) {
        $check = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM branch WHERE branch_name='$name'"));
        if ($check) {
            echo "exists";
            return false;
        }
        $res = $mysql_connect->
        query("INSERT INTO branch (branch_name) VALUES(\"$name\")");
        if ($res) {
            echo "success";
            return false;
        } else {
            echo "failed";
            return false;
        }

    } else {
        echo "denied";
        return false;

    }
    echo "failed";
    return false;
}
echo "empty";
return false;
