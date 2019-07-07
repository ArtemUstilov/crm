<?php
include_once '../funcs.php';
if (!isAuthorized()) header("Location: ../login.php");
include_once '../components/templates/template.php';
include_once '../db.php';


$options['type'] = 'methodsOfObtaining';
$options['text'] = 'Методы оплаты';
$options['edit'] = 3;
$options['btn'] = 3;
$options['btn-text'] = 'Добавить';




echo template(display_data($connection->query('
SELECT method_id AS `id`, method_name AS `название`,  active AS `статус`, VG.name AS `название`
FROM methods_of_obtating MO
'), $options, ''));

