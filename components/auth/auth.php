<?php
if (isset($_POST['login']) && isset($_POST['password'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $login = clean($_POST['login']);
    $password = clean($_POST['password']);
    // $remember_me = clean($_POST['remember_me']);
    $data = mysqli_fetch_assoc($connection->query("
        SELECT *
        FROM users U 
        INNER JOIN branch B ON B.branch_id = U.branch_id 
        WHERE login='$login'
    "));
    $money = mysqli_fetch_assoc($connection->query("
        SELECT money
        FROM branch
        WHERE branch_id IN (SELECT branch_id
                            FROM users
                            WHERE login = '$login')
    "))['money'];
    if ($login != $data['login']) {
        echo "login";
        return false;
    }
    if (!password_verify($password, $data['pass_hash'])) {
        echo "pass";
        return false;
    }
    if (!$data['active']) {
        echo "inactive";
        return false;
    }
    session_start();
    $_SESSION['name'] = $data['first_name'] . ' ' . $data['last_name'];
    $_SESSION['login'] = $data['login'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['password'] = $data['pass_hash'];
    $_SESSION['id'] = $data['user_id'];
    $_SESSION['branch'] = $data['branch_name'];
    $_SESSION['branch_id'] = $data['branch_id'];
    $_SESSION['money'] = $money;
    //$_SESSION['remember_me'] = $remember_me; in future
    echo "success";
}
