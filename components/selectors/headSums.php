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
                  WHERE user_id = '$user_id') 
AND `owner_id` IS NULL
AND `date` >= date('$start') AND `date` <= date('$end')
"))['average_outgo'];

$headSumsRaw = $connection->query('
SELECT O.owner_id, TT.sum
FROM owners O 
LEFT JOIN (
    SELECT O.owner_id AS "id", ((IFNULL(SUM(S.sum),0) - IFNULL( T.outgo_sum,0)) - "' . $averageOutgo . '") AS sum 
FROM shares S 
RIGHT OUTER JOIN owners O ON O.owner_id = S.owner_id 
LEFT OUTER JOIN orders ORD ON ORD.order_id = S.order_id
LEFT OUTER JOIN (SELECT SUM(sum) AS outgo_sum, owner_id
                 FROM outgo
                 WHERE `date` >= date("'.$start.'") AND `date` <= date("'.$end.'")
                 GROUP BY owner_id) T 
ON O.owner_id = T.owner_id 
WHERE O.branch_id = "' . $branch_id . '"
AND ORD.date >= date("'.$start.'") AND ORD.date <= date("'.$end.'")
GROUP BY O.owner_id 
ORDER BY (IFNULL(SUM(S.sum),0) - T.outgo_sum) desc
) TT ON TT.id = O.owner_id
WHERE O.branch_id = "' . $branch_id . '"
');

include_once '../../dev/ChromePhp.php';

ChromePhp::log($headSumsRaw);

echo json_encode(mysqliToArray($headSumsRaw));