<?php
if (isset($_POST['name'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $name = clean($_POST['name']);
    session_start();
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    $exists = mysqliToArray($connection->query("SELECT * FROM virtualgood WHERE `name` = '$name'"));
    if ($exists) {
        echo "exists";
        return false;
    }
    if (heCan($user_data['role'], 3)) {
        $res = $connection->
        query("
                INSERT INTO virtualgood (`name`) VALUES('$name') ");
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
