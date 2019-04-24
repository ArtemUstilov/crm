<?php
include_once './components/static/template.php';
include_once './db.php';
include_once './funcs.php';

echo template(display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS клиент, 
concat(U.last_name, " ", U.first_name) AS сотрудник, 
V.name AS VG, O.sum_vg AS "кол-во", O.real_out_percent AS "%", 
O.sum_currency AS сума, O.method_of_obtaining AS оплата, O.owner_1_sum AS head1, O.owner_2_sum AS head2
FROM orders O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN virtualgood V ON V.vg_id = O.vg_id
'), 'Заказы'));
?>

