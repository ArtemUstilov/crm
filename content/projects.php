<?php
include_once '../funcs.php';
if (!isAuthorized()) header("Location: ../login.php");
include_once '../components/templates/template.php';
include_once '../db.php';


$options['type'] = 'projects';
$options['text'] = 'Проекты';
$options['edit'] = 3;
$options['btn'] = 3;
$options['btn-text'] = 'Добавить';

session_start();
$branch_id = $_SESSION['branch_id'];

echo template(display_data($connection->query('
SELECT project_id AS `id`, project_id AS `Уникальный id`, project_name AS `название`, active AS `статус`
FROM `projects`'), $options, ''));

