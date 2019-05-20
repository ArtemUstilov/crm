<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

session_start();
$branch_name = $_SESSION['branch'];
$branch_id = $_SESSION['branch_id'];
switch (accessLevel()) {
    case 3:
        $info = $connection -> query('
SELECT O.order_id AS `id`, O.order_id AS `номер_заказа`, concat(U.last_name, " ", U.first_name) AS `агент`, B.branch_name AS `отдел`, concat(C.last_name, " ", C.first_name) AS `клиент`, byname AS `логин`,
V.name AS `VG`, O.sum_vg AS "кол-во", O.real_out_percent AS "%", 
concat(O.sum_currency, " ", F.name) AS `сумма`, O.method_of_obtaining AS `оплата`,
O.date AS `дата`, O.description AS `коммент`
FROM orders O
INNER JOIN fiats F ON O.fiat_id = F.fiat_id 
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = C.user_id
INNER JOIN virtualgood V ON V.vg_id = O.vg_id
INNER JOIN branch B ON U.branch_id = B.branch_id
ORDER BY `date` DESC
');
        break;
    case 2:
    case 1:
        $info = $connection -> query("
SELECT O.order_id AS `id`, O.order_id AS `номер_заказа`, concat(U.last_name, ' ', U.first_name) AS `агент`, concat(C.last_name, ' ', C.first_name) AS `клиент`, byname AS `логин`,
V.name AS `VG`, O.sum_vg AS 'кол-во', O.real_out_percent AS '%', 
concat(O.sum_currency, \" \", F.name) AS `сумма`, O.method_of_obtaining AS `оплата`,
O.date AS `дата`, O.description AS `коммент`
FROM orders O
INNER JOIN fiats F ON O.fiat_id = F.fiat_id 
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = C.user_id
INNER JOIN virtualgood V ON V.vg_id = O.vg_id
WHERE U.branch_id = '$branch_id'
ORDER BY `date` DESC
");
        break;
//    case 1:
//        $info = $connection -> query('
//SELECT O.order_id AS `id`, O.order_id AS `номер_заказа`, concat(U.last_name, " ", U.first_name) AS `агент`, concat(C.last_name, " ", C.first_name) AS `клиент`, byname AS `логин`,
//V.name AS `VG`, O.sum_vg AS "кол-во", O.real_out_percent AS "%",
//concat(O.sum_currency, " ", F.name)AS `сумма`, O.method_of_obtaining AS `оплата`,
//O.date AS `дата`, O.description AS `коммент`
//FROM orders O
//INNER JOIN fiats F ON O.fiat_id = F.fiat_id
//INNER JOIN clients C ON C.client_id = O.client_id
//INNER JOIN users U ON U.user_id = C.user_id
//INNER JOIN virtualgood V ON V.vg_id = O.vg_id
//WHERE C.user_id = '.$_SESSION["id"].'
//ORDER BY `date` DESC
//');
//       break;
    default:
        exit();
        break;
}

$clients = $connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS "name", C.client_id AS `id` FROM clients C WHERE user_id ='.$_SESSION["id"].' ');
$vgs = $connection -> query("
SELECT VG.vg_id, `name`, out_percent FROM virtualgood VG LEFT OUTER JOIN (SELECT * FROM vg_data WHERE branch_id = '$branch_id') VD ON VD.vg_id = VG.vg_id
");
$fiat = $connection -> query("
SELECT * FROM fiats
");

$more_data['clients'] = $clients;
$more_data['vgs'] = $vgs;
$more_data['fiat'] = $fiat;

$options['type'] = 'Order';
$options['text'] = 'Продажи';
$options['info'] = true;
$options['btn'] = 1;
$options['btn-max'] = 2;
$options['btn-text'] = 'Добавить';
$options['edit'] = 2;
echo template(display_data($info, $options, $more_data));
?>

