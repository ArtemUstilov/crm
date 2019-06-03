<?php
if (!isset($_POST['owner_id'])) {
    echo json_encode(array("status" => "failed", "error" => "EMPTY"));
    return false;
}
include_once("../../db.php");
include_once("../../funcs.php");
$user_data = $connection->query("UPDATE `users` SET `is_owner` = 0 WHERE `user_id` = '$user_id'");
if ($user_data) {
    echo json_encode(array("status" => "success"));
    return false;
}
echo json_encode(array("status" => "failed", "error" => "CAN_NOT_UPDATE"));
return false;