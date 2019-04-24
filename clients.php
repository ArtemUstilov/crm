<?php
include_once './static/template.php';
include_once './db.php';
include_once './funcs.php';

echo template(display_data($connection -> query('
SELECT concat(last_name, " ", first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, debt AS долг, rollback_sum AS откат, email AS почта
FROM clients
'), 'Клиенты'));
?>
