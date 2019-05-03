<?php
if (isset($_POST['name']) && isset($_POST['url']) && isset($_POST['in']) && isset($_POST['out'])) {

    include_once("../../db.php");
    include_once("../../funcs.php");
    $name = clean($_POST['name']);
    $url = clean($_POST['url']);
    $in = clean($_POST['in']);
    $out = clean($_POST['out']);
    $default = 50;
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if (heCan($user_data['role'], 2)) {
        $res = $connection->
        query("INSERT INTO virtualgood (in_percent,out_percent,name,default_first_owner_percent,api_url_regexp) VALUES(\"$in\",\"$out\",\"$name\",\"$default\",\"$url\") ");
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
