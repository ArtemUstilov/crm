<?php
include_once '../../dev/ChromePhp.php';
ChromePhp::log($_POST['order_id']);
if (isset($_POST['order_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $order_id = clean($_POST['order_id']);
    $order_data = mysqli_fetch_assoc($connection->query("
            SELECT order_id AS 'id', branch_id AS id, 
            concat('[(',C.last_name, ' ', C.first_name,' (', byname,')), (', U.last_name, ' ', U.first_name,')]' ) AS `full_name`,
            C.client_id AS client_id, U.user_id AS user_id, callmaster_id, callmaster_name, rollback_1, rollback_2
            FROM orders O 
            INNER JOIN clients C ON C.client_id = O.client_id
            INNER JOIN users U ON U.user_id = O.user_id
            INNER JOIN (SELECT client_id AS callmaster_id, concat(last_name, ' ', first_name,' (', byname,')') AS callmaster_name, 
                         WHERE client_id = O.callmaster)
            WHERE order_id = '$order_id'
            "));
    $share_data = mysqliToArray($connection->query("
            SELECT share_id AS id, `sum`, share_percent AS percent,
            concat(S.last_name, ' ', S.first_name) AS `owner_name`
            FROM shares S INNER JOIN owners O ON S.owner_id = O.ownerd id
            WHERE order_id = '$order_id'
            "));
    $order_data['shares'] = $share_data;
    if ($order_data) {
        echo json_encode($order_data);
        return false;
    } else {
        echo "failed";
        return false;
    }
}
