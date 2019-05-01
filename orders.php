<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

session_start();
$branch_name = $_SESSION['branch'];
$branch_id = $_SESSION['branch_id'];
switch ($_SESSION['role']) {
    case "admin":
        $info = $connection -> query('
SELECT order_id AS id, concat(U.last_name, " ", U.first_name) AS агент, B.branch_name AS отдел, concat(C.last_name, " ", C.first_name) AS клиент, byname AS логин,
V.name AS VG, O.sum_vg AS "кол-во", O.real_out_percent AS "%", 
O.sum_currency AS сумма, O.method_of_obtaining AS оплата,
O.date AS дата
FROM orders O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN virtualgood V ON V.vg_id = O.vg_id
INNER JOIN branch B ON U.branch_id = B.branch_id
ORDER BY `date` DESC
');
        break;
    case "moder":
        $info = $connection -> query("
SELECT order_id AS id, concat(U.last_name, ' ', U.first_name) AS агент, concat(C.last_name, ' ', C.first_name) AS клиент, byname AS логин,
V.name AS VG, O.sum_vg AS 'кол-во', O.real_out_percent AS '%', 
O.sum_currency AS сумма, O.method_of_obtaining AS оплата,
O.date AS дата
FROM orders O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN virtualgood V ON V.vg_id = O.vg_id
WHERE U.branch_id = '$branch_id'
ORDER BY `date` DESC
");
        break;
    case "agent":
        $info = $connection -> query('
SELECT concat(U.last_name, " ", U.first_name) AS агент, concat(C.last_name, " ", C.first_name) AS клиент, byname AS логин,
V.name AS VG, O.sum_vg AS "кол-во", O.real_out_percent AS "%", 
O.sum_currency AS сумма, O.method_of_obtaining AS оплата,
O.date AS дата
FROM orders O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN virtualgood V ON V.vg_id = O.vg_id
WHERE O.user_id = '.$_SESSION["id"].'
ORDER BY `date` DESC
');
       break;
    default:
        exit();
        break;
}

$clients = $connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS name, C.client_id AS id FROM clients C
');
$vgs = $connection -> query('
SELECT * FROM virtualgood
');


$more_data['clients'] = $clients;
$more_data['vgs'] = $vgs;



echo template(display_data($info, "Order","Продажи", $more_data));
?>

