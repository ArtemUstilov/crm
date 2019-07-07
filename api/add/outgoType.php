<?php
include_once("../../funcs.php");

if (!isset($_POST['name'], $_POST['parentId'])) {
    return error("empty");
}
include_once("../../db.php");
$name = clean($_POST['name']);
$parentId = clean($_POST['parentId']);

session_start();
$branch_id = $_SESSION['branch_id'];

$result = $connection->query("
    INSERT INTO outgo_types
    (outgo_name, branch_id)
    VALUES('$name', '$branch_id');
");
if (!$result) {
    error("failed");
    return false;
}

$currentId = mysqli_fetch_assoc($connection->query("
    SELECT * FROM outgo_types
    ORDER BY outgo_type_id DESC
"))['outgo_type_id'];
if (!$currentId && $currentId !== 0) {
    error("failed");
    return false;
}

$result = $connection->query("
    INSERT INTO outgo_types_relative
    (parent_id, son_id)
    VALUES('$parentId', '$currentId');
");
if (!$result) {
    error("failed");
    return false;
}

echo json_encode(array("status" => "success"));
return false;

