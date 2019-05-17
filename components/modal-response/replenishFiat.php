<?php
if (isset($_POST['fiat']) && isset($_POST['sum'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    session_start();
    $user_id = $_SESSION['id'];
    $branch_id = $_SESSION['branch_id'];
    $fiat = $_POST['fiat'];
    $sum = $_POST['sum'];
    $connection->query("INSERT INTO income_history (fiat, branch_id, sum, user_id) VALUES($fiat, $branch_id, $sum, $user_id)");
    updateBranchMoney($connection, $branch_id, $sum, $fiat);
    echo 'success-replenish';
    return false;
}
echo 'empty';
return false;