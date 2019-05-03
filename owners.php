<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
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
echo template(display_data($connection -> query('
SELECT concat(O.last_name, " ", O.first_name) AS  Имя, branch_name AS предприятие
FROM owners O
INNER JOIN branch B ON B.branch_id = O.branch_id
'), "Head","Владельцы", $data));

