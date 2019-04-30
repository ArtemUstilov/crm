<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
echo template(display_data($connection->query('
SELECT client_id AS id, concat(last_name, " ", first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, debt AS долг, rollback_sum AS откат, email AS почта
FROM clients
'), "Client","Клиенты"));
?>
