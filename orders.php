<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';


$clients = $connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS name, C.client_id AS id FROM clients C
');
$vgs = $connection -> query('
SELECT * FROM virtualgood
');
$more_data['clients'] = $clients;
$more_data['vgs'] = $vgs;



echo template(display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS клиент, byname AS логин,
V.name AS VG, O.sum_vg AS "кол-во", O.real_out_percent AS "%", 
O.sum_currency AS сума, O.method_of_obtaining AS оплата,
O.date AS дата
FROM orders O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN virtualgood V ON V.vg_id = O.vg_id
WHERE O.user_id = '.$_SESSION["id"].'
'), "Order","Продажи", $more_data));
?>

