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
                      FROM (SELECT user_id AS owner_id, branch_id, first_name, last_name FROM users WHERE is_owner = 1) G
                      WHERE G.branch_id = '$branch_id' )
       ) AS average_outgo
FROM outgo
WHERE user_id IN (SELECT user_id
                  FROM users
                  WHERE branch_id = '$branch_id') 
AND `user_as_owner_id` IS NULL
AND `date` >= '".$start." 00:00:00' AND `date` <= '".$end." 23:59:59'
"))['average_outgo'];

$headSumsRaw = $connection->query("
SELECT O.owner_id, IFNULL(sum, 0) AS `sum`
FROM (SELECT user_id AS owner_id, branch_id, first_name, last_name FROM users WHERE is_owner = 1) O 
LEFT JOIN(
SELECT owner_id, SUM(S.sum) AS `sum`
FROM (SELECT user_id AS owner_id, branch_id, first_name, last_name FROM users WHERE is_owner = 1) O
LEFT OUTER JOIN shares S ON S.user_as_owner_id = O.owner_id
LEFT OUTER JOIN orders O ON O.order_id = S.order_id
WHERE O.branch_id = '$branch_id'
AND (O.date >= '".$start." 00:00:00' AND O.date <= '".$end." 23:59:59')
GROUP BY owner_id
) H ON H.owner_id = O.owner_id
WHERE O.branch_id = '$branch_id'
");

echo json_encode(mysqliToArray($headSumsRaw));