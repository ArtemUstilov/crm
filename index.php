<?php
include_once ('funcs.php');
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$table = '';

//TODO replace with unknown number of owners
//$headSumsRaw = $connection -> query('
//SELECT SUM(owner_1_sum) AS sum1, SUM(owner_2_sum) AS sum2
//FROM orders O
//WHERE O.user_id = '.$_SESSION["id"].'
//');
//$headSums = $headSumsRaw ? mysqli_fetch_assoc($headSumsRaw) : null;
//if($headSums) $table .= '<h2>Head1: '.($headSums["sum1"] ? $headSums["sum1"] : 0).' грн</h2><h2> Head2: '.($headSums["sum2"] ? $headSums["sum2"] : 0).' грн</h2>';

$table .= display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE debt > 0 AND O.user_id = '.$_SESSION["id"].'
ORDER BY debt DESC
'), "","Должники");

$sumDebtsRaw = $connection -> query('
SELECT SUM(debt) AS sum
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE O.user_id = '.$_SESSION["id"].'
');
$sumDebts = $sumDebtsRaw ? mysqli_fetch_assoc($sumDebtsRaw) : null;

if($sumDebts) $table .= '<h2>Всего: '.($sumDebts["sum"] ? $sumDebts["sum"] : 0).' грн</h2>';

$table .= display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, C.rollback_sum AS откат
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id = '.$_SESSION["id"].'
'), "rollback-main","Ожидают откаты");

$sumDebtsRaw = $connection -> query('
SELECT SUM(C.rollback_sum) AS sum
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id = '.$_SESSION["id"].'
');
$sumDebts = $sumDebtsRaw ? mysqli_fetch_assoc($sumDebtsRaw) : null;
if($sumDebts) $table .= '<h2>Всего: '.($sumDebts["sum"] ? $sumDebts["sum"] : 0).' грн</h2>';


echo template($table);
