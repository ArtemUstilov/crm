<?php
include_once('funcs.php');
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$table = '';
$role = $_SESSION['role'];
$branch_id = $_SESSION['branch_id'];
$headSumsRaw = $connection->query('
SELECT O.owner_id AS "id", concat(O.last_name, " ", O.first_name) AS "Полное имя", IFNULL(SUM(S.sum),0) AS сумма
FROM shares S
RIGHT OUTER JOIN owners O ON O.owner_id = S.owner_id 
WHERE O.branch_id IN (SELECT branch_id FROM users U WHERE U.user_id = ' . $_SESSION["id"] . ')
GROUP BY O.owner_id 
ORDER BY IFNULL(SUM(S.sum),0) desc
');
$branches = $connection->query('
SELECT branch_id AS id, branch_name
FROM branch
');
$clients = $connection->query('
SELECT *
FROM clients
');
$data['branches'] = $branches;
$data['clients'] = $clients;
$table .= display_data($headSumsRaw, 'Head', "Владельцы", $data);
//$headSums = $headSumsRaw ? mysqli_fetch_assoc($headSumsRaw) : null;
//if($headSums) $table .= '<h2>Head1: '.($headSums["sum1"] ? $headSums["sum1"] : 0).' грн</h2><h2> Head2: '.($headSums["sum2"] ? $headSums["sum2"] : 0).' грн</h2>';

switch ($role) {
    case 'moder':
        $debtorsData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг
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
INNER JOIN orders O ON O.client_id = C.client_id
WHERE debt > 0 AND O.user_id IN(
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
    INNER JOIN orders O ON O.client_id = C.client_id
    WHERE debt > 0 AND O.user_id IN(
        SELECT U.user_id
        FROM users U
        WHERE U.branch_id = ' . $branch_id . '
))
');
        $rollbackData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, C.rollback_sum AS откат
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . ')
');
        $rollbackList = $connection->query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, C.rollback_sum
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id IN(
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
    INNER JOIN orders O ON O.client_id = C.client_id
    WHERE C.rollback_sum > 0 AND O.user_id IN(
        SELECT user_id
        FROM users
        WHERE branch_id = ' . $branch_id . ')
)
');
        break;
    case 'admin':
        $debtorsData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг
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
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, C.rollback_sum AS откат
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
    default:
        $debtorsData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, debt AS долг
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE debt > 0 AND O.user_id = ' . $_SESSION["id"] . '
ORDER BY debt DESC');
        $debtorsList = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS client_name, byname AS login, C.debt
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE debt > 0 AND O.user_id = ' . $_SESSION["id"] . '
ORDER BY debt DESC');
        $sumDebtsRaw = $connection->query('
SELECT SUM(F.debt) AS sum
FROM clients F
WHERE F.client_id IN(
    SELECT DISTINCT C.client_id
    FROM clients C
    INNER JOIN orders O ON O.client_id = C.client_id
    WHERE O.user_id = ' . $_SESSION["id"] . '
    )
');
        $rollbackData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, C.rollback_sum AS откат
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id = ' . $_SESSION["id"] . '
');
        $rollbackList = $connection->query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, C.rollback_sum
FROM clients C
INNER JOIN orders O ON O.client_id = C.client_id
WHERE C.rollback_sum > 0 AND O.user_id = ' . $_SESSION["id"] . '
');
        $rollbackSum = $connection->query('
SELECT SUM(Y.rollback_sum) AS sum
FROM clients Y 
WHERE Y.client_id IN(
    SELECT DISTINCT C.client_id
    FROM clients C
    INNER JOIN orders O ON O.client_id = C.client_id
    WHERE C.rollback_sum > 0 AND O.user_id = ' . $_SESSION["id"] . '
    )
');
        break;
}

$table .= display_data($debtorsData, "Debtor", "Должники", $debtorsList);

$sumDebts = $sumDebtsRaw ? mysqli_fetch_assoc($sumDebtsRaw) : null;

if ($sumDebts) $table .= '<h2>Всего: ' . ($sumDebts["sum"] ? $sumDebts["sum"] : 0) . ' грн</h2>';

$table .= display_data($rollbackData, "RollbackMain", "Ожидают откаты", $rollbackList);

$sumDebts = $rollbackSum ? mysqli_fetch_assoc($rollbackSum) : null;
if ($sumDebts) $table .= '<h2>Всего: ' . ($sumDebts["sum"] ? $sumDebts["sum"] : 0) . ' грн</h2>';


echo template($table);
