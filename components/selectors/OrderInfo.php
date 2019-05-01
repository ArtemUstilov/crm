<?php
if (isset($_POST['order_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $order_id = clean($_POST['order_id']);
    $order_data = mysqliToArray($connection -> query("
        SELECT share_percent, S.sum AS sum, concat(O.last_name, ' ', O.first_name) AS `name`, rollback_1, rollback_2, OD.rollback_sum, concat(C.last_name, ' ', C.first_name) AS callmaster
        FROM shares S
        INNER JOIN owners O ON O.owner_id = S.owner_id
        INNER JOIN orders OD ON OD.order_id = S.order_id
        LEFT JOIN clients C ON C.client_id = OD.callmaster
        WHERE S.order_id='$order_id'
    "));
    if ($order_data) {
        echo json_encode($order_data);
        return false;
    } else {
        echo "failed";
        return false;
    }
}
