<?php
if (isset($_POST['order_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $order_id = clean($_POST['order_id']);
    $order_data = mysqli_fetch_assoc($connection->query("
            SELECT O.order_id AS order_id, U.branch_id AS branch_id, 
            concat('[(',C.last_name, ' ', C.first_name,' (', C.byname,')), (', U.last_name, ' ', U.first_name,')]' ) AS `full_name`,
            C.client_id AS client_id,  concat(T.last_name, ' ', T.first_name,' (', T.byname,')') AS callmaster_name, 
            rollback_1, rollback_2, O.callmaster, U.user_id AS user_id
            FROM orders O 
            INNER JOIN clients C ON C.client_id = O.client_id
            INNER JOIN users U ON U.user_id = O.user_id
            INNER JOIN clients T ON O.callmaster = T.client_id
            WHERE order_id = '$order_id'
            "));
    $share_data = mysqliToArray($connection->query("
            SELECT shares_id AS id, `sum`, share_percent AS percent,
            concat(O.last_name, ' ', O.first_name) AS `owner_name`, O.owner_id AS owner_id
            FROM shares S INNER JOIN owners O ON S.owner_id = O.owner_id
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
