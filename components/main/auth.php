<?php
if (isset($_POST['login']) && isset($_POST['password'])) {
    include_once("../../bd/index.php");
    include_once("../../funcs.php");
    $login = clean($_POST['login']);
    $password = clean($_POST['password']);
   // $remember_me = clean($_POST['remember_me']);
    $data = mysqli_fetch_assoc($mysql_connect->query("SELECT * FROM users U INNER JOIN branch B ON B.branch_id = U.branch_id WHERE login='$login'"));
    if ($login != $data['login']) {
        echo "login";
        return false;
    }
    if (!password_verify($password, $data['pass_hash'])) {
        echo "pass";
        return false;
    }
    session_start();
    $_SESSION['name'] = $data['first_name'].' '.$data['last_name'];
    $_SESSION['login'] = $data['login'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['password'] = $data['pass_hash'];
    $_SESSION['id'] = $data['user_id'];
    $_SESSION['branch'] = $data['branch_name'];
    $_SESSION['money'] = $data['money'];
    //$_SESSION['remember_me'] = $remember_me; in future
    echo "success";
}
