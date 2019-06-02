<?php
if (isset($_POST['name'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $name = clean($_POST['name']);
    $branch_id = clean($_POST['branch_id']);
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if ($user_data && (heCan($user_data['role'], 2))) {
        $res = $connection->
        query("UPDATE branch SET branch_name='$name' WHERE branch_id='$branch_id'");
        if ($res) {
            echo "edit-success";
            return false;
        } else {
            echo "failed";
            return false;
        }

    } else {
        echo "denied";
        return false;

    }
}
echo "empty";
return false;
