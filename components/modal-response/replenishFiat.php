<?php
if (isset($_POST['fiat']) && isset($_POST['sum']) && isset($_POST['owner'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    session_start();
    $user_id = $_SESSION['id'];
    $branch_id = $_SESSION['branch_id'];
    $fiat = clean($_POST['fiat']);
    $sum = clean($_POST['sum']);
    $owner = $_POST['owner'] != 0 ?: $user_id;
    $connection->query("INSERT INTO income_history (fiat, owner_id, `sum`, user_id) VALUES($fiat, $owner, $sum, $user_id)");
    updateBranchMoney($connection, $branch_id, $sum, $fiat);
    echo 'success-replenish';
    return false;
}
echo 'empty';
return false;