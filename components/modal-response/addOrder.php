<?php
if (isset($_POST['client']) && isset($_POST['rollback_1']) && isset($_POST['rollback_2']) && isset($_POST['sum_vg'])
    && isset($_POST['out']) && isset($_POST['obtain']) && isset($_POST['vg'])) {

    include_once("../../bd/index.php");
    include_once("../../funcs.php");
    $sum_vg = clean($_POST['sum_vg']);
    $vg = clean($_POST['vg']);
    $sum_vg = clean($_POST['rollback_1']);
    $client = clean($_POST['client']);
    $sum_vg = clean($_POST['rollback_2']);
    $obtain = clean($_POST['obtaim']);

    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data['role'] == 'admin' || $user_data['role'] == 'sub_admin'|| $user_data['role'] == 'manager'
        || $user_data['role'] == 'moder') {
        $res = $mysql_connect->
        query("INSERT INTO `users` (`login`,`pass_hash`,`first_name`,`last_name`,`role`,`branch_name`, `money`) VALUES('$login','$password','$first_name','$last_name','$role','$branch','$money') ");
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
