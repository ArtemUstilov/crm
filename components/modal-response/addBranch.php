<?php
if (isset($_POST['name'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $name = clean($_POST['name']);
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && iCan(3)) {
        $check = mysqli_fetch_assoc($connection->query("SELECT * FROM branch WHERE branch_name='$name'"));
        if($check)
        {
            echo "exists";
            return false;
        }
        $res = $connection->
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
