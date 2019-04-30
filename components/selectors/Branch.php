<?php
if (isset($_POST['branch_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $branch_id = clean($_POST['branch_id']);
    $branch_data = mysqli_fetch_assoc($connection->query("
            SELECT branch_name AS 'name', branch_id AS id
            FROM branch 
            WHERE branch_id = '$branch_id'
            "));

    if ($branch_data) {
        echo json_encode($branch_data);
        return false;
    } else {
        echo "failed";
        return false;
    }
}
