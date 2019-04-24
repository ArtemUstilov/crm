<?php
if (isset($_POST['login']) && isset($_POST['password'])) {
    include("../../bd/index.php");
    include("../../functions.php");
    $login = clean($_POST['login']);
    $password = clean($_POST['password']);
    $data = mysqli_fetch_array($mysql_connect -> query( "SELECT * FROM `users` WHERE `login`='$login' "));
    if (empty($data['login'])) {
        echo("Invalid login");
        return false;
    }
    if ($password != $data['password']) {
        echo "Invalid pass for `$login`";
        return false;
    }

    session_start();
    $_SESSION['login']=$data['login'];
    $_SESSION['id']=$data['user_id'];
    header("location: ../../index.php");
}
