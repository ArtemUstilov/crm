<?php
if (isset($_POST['login']) && isset($_POST['password'])) {
    include("../../bd/index.php");
    include("../../funcs.php");
    include_once "../../dev/ChromePhp.php";
    $login = clean($_POST['login']);
    $password = clean($_POST['password']);
    $data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users WHERE login='$login'"));
    if ($login != $data['login']) {
        echo "login";
        return false;
    }
    if (!password_verify($password, $data['pass_hash'])) {
        echo "pass";
        return false;
    }
    session_start();
    $_SESSION['login'] = $data['login'];
    $_SESSION['password'] = $data['pass_hash'];
    $_SESSION['id'] = $data['user_id'];

    echo "success";
}
