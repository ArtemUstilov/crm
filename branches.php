<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

$options['type'] = 'Branch';
$options['text'] = 'Предприятия';
$options['btn-text'] = 'Добавить';
$options['btn'] = 3;
echo template(display_data($connection -> query('
SELECT branch_id AS id, branch_name AS название
FROM branch'), $options));

