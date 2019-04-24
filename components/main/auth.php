<?php
if (isset($_POST['login']) && isset($_POST['password'])) {
    include("../../bd/index.php");
    include("../../funcs.php");
    include_once "../../dev/ChromePhp.php";
    $login = clean($_POST['login']);
    $password = clean($_POST['password']);
    $data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE login_hash='$login'"));
    if (empty($data['login_hash'])) {
        echo("Invalid login");
        return false;
    }
    if ($password != $data['pass_hash']) {
        echo "Invalid pass for `$login`";
        return false;
    }
    session_start();
    $_SESSION['login'] = $data['login_hash'];
    $_SESSION['id'] = $data['user_id'];
    header("location: ../../");
}
