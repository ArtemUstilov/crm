<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$branch_id = $_SESSION['branch_id'];
switch ($_SESSION['role']) {
    case "admin":
        $info = $connection -> query("
SELECT B.branch_name AS отдел, concat(U.last_name, ' ', U.first_name) AS агент, concat(C.last_name, ' ', C.first_name) AS клиент, 
O.debt_sum AS сума,
O.date AS дата
FROM debt_history O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN branch B ON B.branch_id = U.branch_id
");
        break;
    case "moder":
        $info = $connection -> query("
SELECT concat(U.last_name, ' ', U.first_name) AS агент, concat(C.last_name, ' ', C.first_name) AS клиент, 
O.debt_sum AS сума,
O.date AS дата
FROM debt_history O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
WHERE U.branch_id = '$branch_id'
");
        break;
    case "agent":
        $info = $connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS клиент, 
O.debt_sum AS сума,
O.date AS дата
FROM debt_history O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
WHERE O.user_id = '.$_SESSION["id"].'
');
        break;
    default:
        exit();
        break;
}
echo template(display_data($info, "Debt","История погашений долгов", $connection -> query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 

byname AS login, debt
FROM clients C
INNER JOIN orders O ON C.client_id = O.client_id
WHERE  debt > 0 AND O.user_id = '.$_SESSION["id"].'
')));

