<?php
if (isset($_POST['name']) && isset($_POST['url']) && isset($_POST['in_percent']) && isset($_POST['out_percent'])) {

    include_once("../../db.php");
    include_once("../../funcs.php");
    $name = clean($_POST['name']);
    $url = clean($_POST['url']);
    $in = clean($_POST['in_percent']);
    $out = clean($_POST['out_percent']);
    $vg_id = clean($_POST['vg_id']);
    $default = 50;
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if (heCan($user_data['role'],2)) {
        $res = $connection->
        query("
        UPDATE `virtualgood`
        SET
            `out_percent`='$out',
            `in_percent`='$in',
            `name`='$name',
            `api_url_regexp`='$url'
        WHERE 
            `vg_id`='$vg_id' 
        ");
        if ($res) {
            echo "edit-success";
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
