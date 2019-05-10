<?php
include_once('funcs.php');
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$table = '';
$branch_id = $_SESSION['branch_id'];
$user_id = $_SESSION['id'];

$averageOutgo = mysqli_fetch_array($connection->query("
SELECT (SUM(`sum`) / (SELECT COUNT(*)
                      FROM (SELECT user_id AS owner_id, first_name, last_name FROM users WHERE is_owner = 1)
                      WHERE branch_id = '$branch_id' )
       ) AS average_outgo
FROM outgo
WHERE user_id IN (SELECT user_id
                  FROM users
                  WHERE branch_id = '$branch_id') 
AND `owner_id` IS NULL
"))['average_outgo'];

$headSumsRaw = $connection->query('
SELECT O.owner_id AS "id", concat(O.last_name, " ", O.first_name) AS "Полное имя", 
(IFNULL(SUM(S.sum),0) - "' . $averageOutgo . '") AS прибыль, ((IFNULL(SUM(S.sum),0) - IFNULL( T.outgo_sum,0)) - "' . $averageOutgo . '") AS остаток

FROM shares S 
RIGHT OUTER JOIN (SELECT user_id AS owner_id, first_name, last_name, branch_id FROM users WHERE is_owner = 1) O ON O.owner_id = S.owner_id 
LEFT OUTER JOIN (SELECT SUM(sum) AS outgo_sum, user_as_owner_id
                 FROM outgo
                 GROUP BY owner_id) T 
ON O.owner_id = T.owner_id 
WHERE O.branch_id = "' . $branch_id . '"
GROUP BY O.owner_id 
ORDER BY (IFNULL(SUM(S.sum),0) - T.outgo_sum) desc
');


$branches = $connection->query("
SELECT branch_id AS id, branch_name
FROM branch
");
$users = $connection->query('
SELECT *
FROM users
');
$data['branches'] = $branches;
$data['users'] = $users;
$options['type'] = 'Head';
$options['text'] = 'Владельцы';
$options['range'] = 1;
$table .= display_data($headSumsRaw, $options, $data);
//$headSums = $headSumsRaw ? mysqli_fetch_assoc($headSumsRaw) : null;
//if($headSums) $table .= '<h2>Head1: '.($headSums["sum1"] ? $headSums["sum1"] : 0).' грн</h2><h2> Head2: '.($headSums["sum2"] ? $headSums["sum2"] : 0).' грн</h2>';
$options = [];

switch (accessLevel()) {
    case 2:

        $debtorsData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг, C.client_id AS id
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE debt > 0 AND O.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . '
)
ORDER BY debt DESC');
        $debtorsList = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS client_name, byname AS login, C.debt
FROM clients C
WHERE debt > 0 AND C.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . '
)
ORDER BY debt DESC
');
        $sumDebtsRaw = $connection->query('
SELECT SUM(F.debt) AS sum
FROM clients F
WHERE F.client_id IN(
    SELECT DISTINCT C.client_id
    FROM clients C
    WHERE debt > 0 AND C.user_id IN(
        SELECT U.user_id
        FROM users U
        WHERE U.branch_id = ' . $branch_id . '
))
');
        $rollbackData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, C.rollback_sum AS откат, C.client_id AS id
FROM clients C
WHERE C.rollback_sum > 0 AND C.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . ')
');
        $rollbackList = $connection->query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, C.rollback_sum
FROM clients C
WHERE C.rollback_sum > 0 AND C.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . ')
');
        $rollbackSum = $connection->query('
SELECT SUM(Y.rollback_sum) AS sum
FROM clients Y 
WHERE Y.client_id IN(
    SELECT DISTINCT C.client_id
    FROM clients C
    WHERE C.rollback_sum > 0 AND C.user_id IN(
        SELECT user_id
        FROM users
        WHERE branch_id = ' . $branch_id . ')
)
');
        break;
    case 3:
        $debtorsData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг, client_id AS id
FROM clients C
WHERE debt > 0
ORDER BY debt DESC');
        $debtorsList = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS client_name, byname AS login, C.debt
FROM clients C
WHERE debt > 0
ORDER BY debt DESC');
        $sumDebtsRaw = $connection->query('
SELECT SUM(debt) AS sum
FROM clients C
');
        $rollbackData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, C.rollback_sum AS откат, client_id AS id
FROM clients C
WHERE rollback_sum > 0
');
        $rollbackList = $connection->query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, C.rollback_sum
FROM clients C
WHERE rollback_sum > 0
');
        $rollbackSum = $connection->query('
SELECT SUM(C.rollback_sum) AS sum
FROM clients C
WHERE rollback_sum > 0
');
        break;
    case 1:
        $debtorsData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг, C.client_id AS id
FROM clients C
WHERE debt > 0 AND C.user_id = ' . $_SESSION["id"] . '
ORDER BY debt DESC');
        $debtorsList = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS client_name, byname AS login, C.debt
FROM clients C
WHERE debt > 0 AND C.user_id = ' . $_SESSION["id"] . '
ORDER BY debt DESC');
        $sumDebtsRaw = $connection->query('
SELECT SUM(F.debt) AS sum
FROM clients F
WHERE F.client_id IN(
    SELECT DISTINCT C.client_id
    FROM clients C
    WHERE C.user_id = ' . $_SESSION["id"] . '
    )
');
        $rollbackData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, C.rollback_sum AS откат, C.client_id AS id
FROM clients C
WHERE C.rollback_sum > 0 AND C.user_id = ' . $_SESSION["id"] . '
');
        $rollbackList = $connection->query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, C.rollback_sum
FROM clients C
WHERE C.rollback_sum > 0 AND C.user_id = ' . $_SESSION["id"] . '
');
        $rollbackSum = $connection->query('
SELECT SUM(Y.rollback_sum) AS sum
FROM clients Y 
WHERE Y.client_id IN(
    SELECT DISTINCT C.client_id
    FROM clients C
    WHERE C.rollback_sum > 0 AND C.user_id = ' . $_SESSION["id"] . '
    )
');
        break;
}

$options['type'] = 'Debt';
$options['text'] = 'Должники';
$options['coins'] = true;
$options['btn-text'] = 'Погасить';
$options['btn'] = 1;
$options['modal'] = 'Debt-Modal';
$table .= display_data($debtorsData, $options, $debtorsList);

$sumDebts = $sumDebtsRaw ? mysqli_fetch_assoc($sumDebtsRaw) : null;

if ($sumDebts) $table .= '<h2>Всего: ' . ($sumDebts["sum"] ? $sumDebts["sum"] : 0) . ' грн</h2>';

$options['type'] = 'Rollback';
$options['text'] = 'Ожидают откаты';
$options['coins'] = true;
$options['btn-text'] = 'Выплатить';
$options['btn'] = 1;
$options['modal'] = 'Rollback-Modal';
$table .= display_data($rollbackData, $options, $rollbackList);

$sumDebts = $rollbackSum ? mysqli_fetch_assoc($rollbackSum) : null;
if ($sumDebts) $table .= '<h2>Всего: ' . ($sumDebts["sum"] ? $sumDebts["sum"] : 0) . ' грн</h2>';


echo template($table);
