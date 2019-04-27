<?php
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['branch'])) {
    include_once("../../bd/index.php");
    include_once("../../funcs.php");
    $first_name = clean($_POST['first_name']);
    $last_name = clean($_POST['last_name']);
    $branch = clean($_POST['branch']);
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && ($user_data['role'] == "admin" || $user_data['role'] == "sub-admin" || $user_data['role'] == "manager"
            || $user_data['role'] == "moder")) {
//        $check = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM branch WHERE branch_name='$name'"));
//        if ($check) {
//            echo "exists";
//            return false;
//        }
        $branch_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM branch WHERE branch_id='$branch'"));
        if (!$branch_data) {
            echo "doesNotExists";
            return false;
        }
        $res = $mysql_connect->
        query("INSERT INTO `owners` (`branch_id`, `last_name`,  `first_name`) VALUES($branch,'$last_name', '$first_name')");
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
