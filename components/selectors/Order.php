<?php
include_once '../../dev/ChromePhp.php';
if (isset($_POST['order_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $order_id = clean($_POST['order_id']);
    $order_data = mysqli_fetch_assoc($connection->query("
            SELECT O.order_id AS order_id, U.branch_id AS branch_id, 
            concat('[(',C.last_name, ' ', C.first_name,' (', C.byname,')), (', U.last_name, ' ', U.first_name,')]' ) AS `full_name`,
            C.client_id AS client_id, rollback_1, O.callmaster, U.user_id AS user_id, O.method_of_obtaining AS method, 
            O.vg_id, O.sum_vg, O.real_out_percent AS 'out', O.order_debt AS debt, O.description AS comment
            FROM orders O 
            INNER JOIN clients C ON C.client_id = O.client_id
            INNER JOIN users U ON U.user_id = C.user_id
            LEFT JOIN clients T ON O.callmaster = T.client_id
            WHERE order_id = '$order_id'
            "));

    $shares_data = mysqliToArray($connection->query("
            SELECT shares_id AS id, share_percent AS percent,
            concat(O.last_name, ' ', O.first_name) AS `owner_name`, O.owner_id AS owner_id
            FROM shares S INNER JOIN (SELECT user_id AS owner_id, first_name, last_name FROM users WHERE is_owner = 1) O ON S.user_as_owner_id = O.owner_id
            WHERE order_id = '$order_id'
            "));

    $other_owners_data = mysqliToArray($connection->query("
            SELECT concat(last_name, ' ', first_name) AS `owner_name`, owner_id 
            FROM (SELECT user_id AS owner_id, first_name, branch_id, last_name FROM users WHERE is_owner = 1) O
            WHERE owner_id NOT IN (SELECT user_as_owner_id
                                   FROM shares
                                   WHERE order_id ='$order_id') 
            AND branch_id IN(SELECT U.branch_id
                             FROM orders O INNER JOIN clients C ON C.client_id = O.client_id
                             INNER JOIN users U ON C.user_id = U.user_id
                             WHERE O.order_id = '$order_id')
            "));
    $possible_client_data = mysqliToArray($connection->query("
       SELECT client_id 
        FROM clients
        WHERE client_id IN (
            SELECT client_id
            FROM orders
            WHERE client_id IN(
                SELECT client_id
                FROM clients C INNER JOIN users U ON C.user_id = U.user_id
                WHERE branch_id IN (
                	SELECT branch_id FROM users U
                    INNER JOIN clients C ON U.user_id = C.user_id
                    INNER JOIN orders O ON O.client_id = C.client_id
                    WHERE order_id = '$order_id'
                )
            )
        )
    "));
    ChromePhp::log($possible_client_data);
    if($shares_data)
    $order_data['shares'] = $shares_data;
    if($other_owners_data)
    $order_data['other_owners'] = $other_owners_data;
    $order_data['clients'] = $possible_client_data;

    if ($order_data) {
        echo json_encode($order_data);
        return false;
    } else {
        echo "failed";
        return false;
    }
}
