<?php
include_once ('funcs.php');
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$table = '';

$headSumsRaw = $connection -> query('
SELECT concat(O.last_name, " ", O.first_name) AS "Полное имя", IFNULL(SUM(S.sum),0) AS сумма
FROM shares S
RIGHT OUTER JOIN owners O ON O.owner_id = S.owner_id 
WHERE O.branch_id IN (SELECT branch_id FROM users U WHERE U.user_id = '.$_SESSION["id"].')
GROUP BY O.owner_id 
ORDER BY IFNULL(SUM(S.sum),0) desc
');
$branches = $connection -> query('
SELECT branch_id AS id, branch_name
FROM branch
');
$clients = $connection -> query('
SELECT *
FROM clients
');
$data['branches'] = $branches;
$data['clients'] = $clients;
$table .= display_data($headSumsRaw, 'Head', "Владельцы", $data);
//$headSums = $headSumsRaw ? mysqli_fetch_assoc($headSumsRaw) : null;
//if($headSums) $table .= '<h2>Head1: '.($headSums["sum1"] ? $headSums["sum1"] : 0).' грн</h2><h2> Head2: '.($headSums["sum2"] ? $headSums["sum2"] : 0).' грн</h2>';

$table .= display_data($connection -> query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE debt > 0 AND O.user_id = '.$_SESSION["id"].'
ORDER BY debt DESC
'), "Debtor","Должники",($connection -> query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS client_name, byname AS login, C.debt
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE debt > 0 AND O.user_id = '.$_SESSION["id"].'
ORDER BY debt DESC
')));

$sumDebtsRaw = $connection -> query('
SELECT SUM(debt) AS sum
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE O.user_id = '.$_SESSION["id"].'
');
$sumDebts = $sumDebtsRaw ? mysqli_fetch_assoc($sumDebtsRaw) : null;

if($sumDebts) $table .= '<h2>Всего: '.($sumDebts["sum"] ? $sumDebts["sum"] : 0).' грн</h2>';

$table .= display_data($connection -> query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, C.rollback_sum AS откат
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id = '.$_SESSION["id"].'
'), "RollbackMain","Ожидают откаты", $connection -> query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, C.rollback_sum
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id = '.$_SESSION["id"].'
'));
$sumDebtsRaw = $connection -> query('
SELECT SUM(C.rollback_sum) AS sum
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id = '.$_SESSION["id"].'
');
$sumDebts = $sumDebtsRaw ? mysqli_fetch_assoc($sumDebtsRaw) : null;
if($sumDebts) $table .= '<h2>Всего: '.($sumDebts["sum"] ? $sumDebts["sum"] : 0).' грн</h2>';


echo template($table);
