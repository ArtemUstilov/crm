<?php
if (isset($_POST['fiat']) && isset($_POST['sum'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    session_start();
    $branch_id = $_SESSION['branch_id'];
    $fiat = $_POST['fiat'];
    $sum = $_POST['sum'];
    $check_payment_branch_fiat = mysqli_fetch_array($connection->
    query("SELECT * FROM payments
                              WHERE `fiat_id` = '$fiat' AND `branch_id` = '$branch_id' "));
    if ($check_payment_branch_fiat)
        $update_payment_branch_fiat = $connection->
        query("UPDATE  `payments` 
                                  SET `sum` = `sum` + '$sum'
                                  WHERE branch_id = '$branch_id' AND `fiat_id` = '$fiat'");
    else
        $insert_payment_branch_fiat = $connection->
        query("INSERT INTO `payments` 
                             (`fiat_id`, `sum`, `branch_id`)
                             VALUES('$fiat', '$sum', '$branch_id') ");
    if ($update_payment_branch_fiat || $insert_payment_branch_fiat) {
        echo 'success-replenish';
        return false;
    }
    echo 'failed';
    return false;
}
echo 'empty';
return false;