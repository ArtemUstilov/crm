<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
session_start();
$branch_id = $_SESSION['branch_id'];
include "./dev/ChromePhp.php";
for($i = 1; $i <= 12; $i++){
    $index = $i < 10 ? '0'.$i : $i;
    $headSumsRaw = $connection->query("
SELECT concat(U.user_id, '-', F.fiat_id) AS id, IFNULL(SUM(S.sum), 0) AS sum, IFNULL(S.fiat_id, F.fiat_id) AS fiat_id
FROM users U
JOIN fiats F
LEFT JOIN (
    SELECT O.fiat_id, S.user_as_owner_id, S.sum 
    FROM shares S
    INNER JOIN orders O ON O.order_id = S.order_id
    WHERE (O.date >= '2019-".$index."-01 00:00:00' AND O.date <= '2019-".$index."-31 23:59:59')
) S ON S.user_as_owner_id = U.user_id AND S.fiat_id = F.fiat_id
WHERE U.is_owner = 1 AND U.branch_id = '.$branch_id.' 
GROUP BY U.user_id, IFNULL(S.fiat_id, F.fiat_id)
");
    ChromePhp::log(mysqliToArray($headSumsRaw));
}
