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
    SELECT O.owner_id AS "id", ((IFNULL(SUM(S.sum),0) - IFNULL( T.outgo_sum,0)) - "' . $averageOutgo . '") AS "sum"
FROM shares S 
RIGHT OUTER JOIN owners O ON O.owner_id = S.owner_id 
LEFT OUTER JOIN orders ORD ON ORD.order_id = S.order_id
LEFT OUTER JOIN (SELECT SUM(`sum`) AS outgo_sum, owner_id
                 FROM outgo
                 WHERE `date` >="'.$start.' 00:00:00" AND `date` <= "'.$end.' 23:59:59"
                 GROUP BY owner_id) T
ON O.owner_id = T.owner_id
WHERE O.branch_id = "' . $branch_id . '"
AND ORD.date >= "'.$start.' 00:00:00" AND ORD.date <= "'.$end.' 23:59:59"
GROUP BY O.owner_id
ORDER BY (IFNULL(SUM(S.sum),0) - T.outgo_sum) desc
) TT ON TT.id = O.owner_id
WHERE O.branch_id = "' . $branch_id . '"
');

echo json_encode(mysqliToArray($headSumsRaw));