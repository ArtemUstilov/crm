<?php
if (isset($_POST['fiat'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $fiat = clean($_POST['fiat']);
    session_start();
    $fiat_data = mysqli_fetch_assoc($connection->query("
    SELECT * FROM fiats WHERE fiat_id = '$fiat'
    "));

    if ($fiat_data) {
        echo json_encode($fiat_data);
        return false;
    } else {
        echo "failed";
        return false;
    }
}
