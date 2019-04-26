<?php
include_once ('funcs.php');
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$table = '';
$headSums = mysqli_fetch_assoc($connection -> query('
SELECT SUM(owner_1_sum) AS sum1, SUM(owner_2_sum) AS sum2
FROM orders O
WHERE O.user_id = '.$_SESSION["id"].'
'));

$table .= '<h2>Head1: '.$headSums["sum1"].' грн</h2><h2> Head2: '.$headSums["sum2"].' грн</h2>';
$table .= display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE debt > 0 AND O.user_id = '.$_SESSION["id"].'
ORDER BY debt DESC
'), "","Должники");

$sumDebts = mysqli_fetch_assoc($connection -> query('
SELECT SUM(debt) AS sum
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE O.user_id = '.$_SESSION["id"].'
'));

$table .= '<h2>Всего: '.$sumDebts["sum"].' грн</h2>';

$table .= display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, R.rollback_sum AS откат
FROM clients C
INNER JOIN rollback_paying R ON R.client_id = C.client_id
WHERE R.rollback_sum > 0 AND R.user_id = '.$_SESSION["id"].'
ORDER BY R.rollback_sum DESC
'), "","Откаты");

$sumDebts = mysqli_fetch_assoc($connection -> query('
SELECT SUM(R.rollback_sum) AS sum
FROM clients C
INNER JOIN rollback_paying R ON R.client_id = C.client_id
WHERE R.rollback_sum > 0 AND R.user_id = '.$_SESSION["id"].'
'));
$table .= '<h2>Всего: '.$sumDebts["sum"].' грн</h2>';


echo template($table);
