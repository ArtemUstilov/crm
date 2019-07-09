<?php
include_once '../funcs.php';
if (!isAuthorized()) header("Location: ../login.php");
include_once '../components/templates/template.php';
include_once '../db.php';


$options['type'] = 'MethodsOfObtaining';
$options['text'] = 'Методы оплаты';
$options['edit'] = 3;
$options['btn'] = 3;
$options['btn-text'] = 'Добавить';


echo template(display_data($connection->query('
SELECT method_id AS `id`, method_name AS `название`, active AS `статус`, method_name AS `название`, participates_in_balance AS `участие в балансе`
FROM `methods_of_obtaining`
'), $options, ''));

