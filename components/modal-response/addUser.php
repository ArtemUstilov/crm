<?php
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['branch']) && isset($_POST['role'])
    && isset($_POST['first_name']) && isset($_POST['last_name'])) {

    include_once("../../bd/index.php");
    include_once("../../funcs.php");
    $money = 0;
    $login = clean($_POST['login']);
    $password = password_hash(clean($_POST['password']), PASSWORD_DEFAULT);
    $role = clean($_POST['role']);
    $first_name = clean($_POST['first_name']);
    $last_name = clean($_POST['last_name']);
    $branch = clean($_POST['branch']);
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE user_id='$user_id'"));
    $check_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE login='$login'"));
    if ($check_data) {
        echo "exists";
        return false;
    }
    if ($user_data['role'] == 'admin' || $user_data['role'] == 'sub_admin') {
        $res = $mysql_connect->
        query("INSERT INTO `users` (`login`,`pass_hash`,`first_name`,`last_name`,`role`,`branch_id`, `money`) VALUES('$login','$password','$first_name','$last_name','$role','$branch','$money') ");
        if ($res) {
            echo "success";
            return false;
        } else {
            echo "failed";
            return false;
        }
    }
    echo "denied";
    return false;
} else {
    echo "empty";
}