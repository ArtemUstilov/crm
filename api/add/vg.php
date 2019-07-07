<?php
if (isset($_POST['name']) && isset($_POST['in']) && isset($_POST['out'])) {

    include_once("../../db.php");
    include_once("../../funcs.php");
    $name = clean($_POST['name']);
    $prevId = clean($_POST['prevId']);
    $url = clean($_POST['url']);
    $key = clean($_POST['key']);
    $in = clean($_POST['in']);
    $out = clean($_POST['out']);
    session_start();
    $user_id = $_SESSION['id'];
    $branch_id = $_SESSION['branch_id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    $exists = mysqliToArray($connection->query("SELECT * FROM vg_data WHERE `name` = '$name' AND `brnach_id` = $branch_id"));
    if ($exists) {
        echo "exists";
        return false;
    }
    if (heCan($user_data['role'], 2)) {
            $res = $connection->
            query("
                INSERT INTO vg_data (
                `name`,
                    `in_percent`,
                    `out_percent`,
                    `access_key`,
                   `api_url_regexp`,
                    `vg_id`,
                    `branch_id`
                ) VALUES('$name', '$in','$out','$key','$url', '$prevId', '$branch_id') ");
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
