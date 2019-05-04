<?php
include_once('../../funcs.php');
if (!isAuthorized()) header("Location: ./login.php");
include_once '../../db.php';
$table = '';
$branch_id = $_SESSION['branch_id'];
$user_id = $_SESSION['id'];
$start = clean($_POST['start']);
$end = clean($_POST['end']);


$averageOutgo = mysqli_fetch_array($connection->query("
SELECT (SUM(`sum`) / (SELECT COUNT(*)
                      FROM owners
                      WHERE branch_id = '$branch_id' )
       ) AS average_outgo
FROM outgo
WHERE user_id IN (SELECT user_id
                  FROM users
                  WHERE branch_id = '$branch_id') 
AND `owner_id` IS NULL
AND `date` >= '".$start." 00:00:00' AND `date` <= '".$end." 23:59:59'
"))['average_outgo'];

$headSumsRaw = $connection->query('
SELECT O.owner_id, TT.sum
FROM owners O
LEFT JOIN (

    SELECT O.owner_id AS "id", (IFNULL(SUM(S.sum),0) - "' . $averageOutgo . '") AS sum
FROM owners O
LEFT OUTER JOIN shares S ON O.owner_id = S.owner_id
LEFT OUTER JOIN orders ORD ON ORD.order_id = S.order_id
LEFT OUTER JOIN outgo T ON T.owner_id = O.owner_id
WHERE O.branch_id = "' . $branch_id . '"
AND (ORD.date >= "'.$start.' 00:00:00" AND ORD.date <= "'.$end.' 23:59:59") OR (T.date >= "'.$start.' 00:00:00" AND T.date <= "'.$end.' 23:59:59")
GROUP BY O.owner_id
ORDER BY (IFNULL(SUM(S.sum),0) - IFNULL(SUM(T.sum),0)) desc
) TT ON TT.id = O.owner_id
WHERE O.branch_id = "' . $branch_id . '"
');

echo json_encode(mysqliToArray($headSumsRaw));