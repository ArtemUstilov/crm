<?php
include_once('funcs.php');
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$table = '';
$branch_id = $_SESSION['branch_id'];
$user_id = $_SESSION['id'];


$headSumsRaw = $connection->query('
SELECT concat(U.user_id,"-", F.fiat_id) AS id, concat(U.last_name, " ", U.first_name) AS "имя", IFNULL(SUM(S.sum), 0) AS прибыль, IFNULL(SUM(S.sum), 0) - IFNULL(UT.sum, 0) AS остаток, F.full_name AS валюта
FROM users U
LEFT JOIN shares S ON S.user_as_owner_id = U.user_id
LEFT JOIN orders ORD ON S.order_id = ORD.order_id
LEFT JOIN (
	SELECT U.user_id, IFNULL(SUM(O.sum), 0) + IFNULL(outcome,0) AS sum, IFNULL(O.fiat_id, T.fiat_id) AS fiat_id
	FROM users U
	LEFT JOIN outgo O ON O.user_as_owner_id = U.user_id
	LEFT JOIN (
		SELECT SUM(sum)/(SELECT COUNT(DISTINCT user_id) FROM users WHERE branch_id = '.$branch_id.' AND is_owner = 1) AS outcome, fiat_id
		FROM outgo
		INNER JOIN users U ON U.user_id = outgo.user_id
		WHERE user_as_owner_id IS NULL AND U.branch_id = '.$branch_id.'
		GROUP BY fiat_id
	) T ON T.fiat_id = O.fiat_id OR O.fiat_id IS NULL
	WHERE U.is_owner = 1 AND U.branch_id = '.$branch_id.'
	GROUP BY U.user_id, O.fiat_id
) UT ON UT.user_id = U.user_id AND (UT.fiat_id = ORD.fiat_id OR ORD.fiat_id IS NULL)
INNER JOIN fiats F ON ORD.fiat_id = F.fiat_id OR UT.fiat_id = F.fiat_id
WHERE U.is_owner = 1 AND U.branch_id = '.$branch_id.'
GROUP BY U.user_id, ORD.fiat_id
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
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, P.sum AS долг, C.client_id AS id, F.name AS валюта 
FROM clients C
INNER JOIN payments P ON P.client_debt_id = C.client_id 
INNER JOIN fiats F ON P.fiat_id = F.fiat_id 
WHERE C.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . '
) AND P.sum > 0
ORDER BY P.sum DESC');
        $debtorsList = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS client_name, byname AS login, P.sum AS debt, fiat_id
FROM clients C
INNER JOIN payments P ON P.client_debt_id = C.client_id 
WHERE C.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . '
) AND P.sum > 0
ORDER BY P.sum DESC
');
        $sumDebtsRaw = $connection->query('
SELECT SUM(P.sum) AS sum
FROM clients F
INNER JOIN payments P ON P.client_debt_id = F.client_id 
WHERE F.client_id IN(
    SELECT DISTINCT C.client_id
    FROM clients C
    WHERE C.user_id IN(
        SELECT U.user_id
        FROM users U
        WHERE U.branch_id = ' . $branch_id . '
)) AND P.sum > 0
');
        $rollbackData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, P.sum AS откат, C.client_id AS id, F.name AS валюта
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
INNER JOIN fiats F ON P.fiat_id = F.fiat_id 
WHERE C.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . ') AND P.sum > 0
');
        $rollbackList = $connection->query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, P.sum AS rollback_sum, fiat_id
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
WHERE C.user_id IN(
    SELECT user_id
    FROM users
    WHERE branch_id = ' . $branch_id . ') AND P.sum > 0
');
        $rollbackSum = $connection->query('
SELECT SUM(P.sum) AS sum, fiat_id, full_name
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
WHERE C.rollback_sum > 0 AND C.user_id IN(
        SELECT user_id
        FROM users
        WHERE branch_id = ' . $branch_id . ')
GROUP BY fiat_id
');
        break;
    case 3:
        $debtorsData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, P.sum AS долг, client_id AS id, F.name AS валюта
FROM clients C
INNER JOIN payments P ON P.client_debt_id = C.client_id 
INNER JOIN fiats F ON P.fiat_id = F.fiat_id 
WHERE P.sum > 0
ORDER BY P.sum DESC');
        $debtorsList = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS client_name, byname AS login, P.sum AS debt, fiat_id
FROM clients C
INNER JOIN payments P ON P.client_debt_id = C.client_id 
WHERE P.sum > 0
ORDER BY P.sum DESC');
        $sumDebtsRaw = $connection->query('
SELECT SUM(P.sum) AS sum
FROM clients C
INNER JOIN payments P ON P.client_debt_id = C.client_id 
');
        $rollbackData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, P.sum AS откат, client_id AS id, F.name AS валюта
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
INNER JOIN fiats F ON P.fiat_id = F.fiat_id 
WHERE P.sum > 0
');
        $rollbackList = $connection->query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, P.sum AS rollback_sum, fiat_id
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
WHERE P.sum > 0
');
        $rollbackSum = $connection->query('
SELECT SUM(P.sum) AS sum, fiat_id, full_name
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
GROUP BY fiat_id
');
        break;
    case 1:
        $debtorsData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, P.sum AS долг, C.client_id AS id, F.name AS валюта
FROM clients C
INNER JOIN payments P ON P.client_debt_id = C.client_id 
INNER JOIN fiats F ON P.fiat_id = F.fiat_id 
WHERE C.user_id = ' . $_SESSION["id"] . ' AND P.sum > 0
ORDER BY P.sum DESC');
        $debtorsList = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS client_name, byname AS login, P.sum AS debt, fiat_id
FROM clients C
INNER JOIN payments P ON P.client_debt_id = C.client_id 
WHERE C.user_id = ' . $_SESSION["id"] . ' AND P.sum > 0
ORDER BY P.sum DESC');
        $sumDebtsRaw = $connection->query('
SELECT SUM(P.sum) AS sum
FROM clients F
INNER JOIN payments P ON P.client_debt_id = F.client_id 
WHERE F.client_id IN(
    SELECT DISTINCT C.client_id
    FROM clients C
    WHERE C.user_id = ' . $_SESSION["id"] . '
    )
');
        $rollbackData = $connection->query('
SELECT DISTINCT concat(C.last_name, " ", C.first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, email AS почта, P.sum AS откат, C.client_id AS id, F.name AS валюта
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
INNER JOIN fiats F ON P.fiat_id = F.fiat_id 
WHERE C.user_id = ' . $_SESSION["id"] . ' AND P.sum > 0
');
        $rollbackList = $connection->query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, P.sum AS rollback_sum, fiat_id
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
WHERE C.user_id = ' . $_SESSION["id"] . ' AND P.sum > 0
');
        $rollbackSum = $connection->query('
SELECT SUM(P.sum) AS sum, fiat_id, full_name
FROM clients C
INNER JOIN payments P ON P.client_rollback_id = C.client_id 
WHERE C.rollback_sum > 0 AND C.user_id = ' . $_SESSION["id"] . '
GROUP BY fiat_id
');
        break;
}
$fiats = $connection->query("SELECT * FROM fiats");
$data['fiats'] = $fiats;
$data['clients'] = $debtorsList;

$options['type'] = 'Debt';
$options['text'] = 'Должники';
$options['coins'] = true;
$options['btn-text'] = 'Погасить';
$options['btn'] = 1;
$options['modal'] = 'Debt-Modal';
$table .= display_data($debtorsData, $options, $data);

$sumDebts = $sumDebtsRaw ? mysqli_fetch_assoc($sumDebtsRaw) : null;

if ($sumDebts) $table .= '<h2>Всего: ' . ($sumDebts["sum"] ? $sumDebts["sum"] : 0) . ' грн</h2>';
$fiats = $connection->query("SELECT * FROM fiats");
$data['clients'] = $rollbackList;
$data['fiats'] = $fiats;
$options['type'] = 'Rollback';
$options['text'] = 'Ожидают откаты';
$options['coins'] = true;
$options['btn-text'] = 'Выплатить';
$options['btn'] = 1;
$options['modal'] = 'Rollback-Modal';

$table .= display_data($rollbackData, $options, $data);

$sumDebts = $rollbackSum ? mysqliToArray($rollbackSum) : null;
if ($sumDebts) {
    foreach ($sumDebts as $key => $var) {
        $output .= '<p >' . $var['sum'] . $var['full_name'] .'</option>';
    }
    $table .= '<h2>Всего: ' . ($sumDebts["sum"] ? $sumDebts["sum"] : 0) . ' грн</h2>';
}


echo template($table);
