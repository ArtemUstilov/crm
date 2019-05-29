<?php
include_once '../../db.php';
session_start();
//TODO replace with val from session
//$client_id = $_SESSION['client_id'];
$client_id = 1;

$vgs = $connection->query("
    SELECT V.vg_id, `name`, out_percent 
    FROM vg_data D
    INNER JOIN virtualgood V ON V.vg_id = D.vg_id
    WHERE branch_id IN (
        SELECT branch_id
        FROM users
        WHERE user_id IN(
            SELECT user_id
            FROM clients
            WHERE client_id = '$client_id'
        )
    )
");
$vgarray = array();
while ($row_user = mysqli_fetch_assoc($vgs))
    $vgarray[] = $row_user;
echo json_encode(array("vgs"=>$vgarray));