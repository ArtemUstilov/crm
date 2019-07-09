<?php
include_once '../funcs.php';
if (!isAuthorized()) header("Location: ../login.php");
include_once '../components/templates/template.php';
include_once '../db.php';


$options['type'] = 'Project';
$options['text'] = 'Проекты';
$options['edit'] = 1;
$options['btn'] = 1;
$options['btn-text'] = 'Добавить';

session_start();
$branch_id = $_SESSION['branch_id'];
switch (accessLevel()) {
    case 3:
        $data = 'SELECT project_id AS `id`, project_id AS `Уникальный id`, branch_name AS `предприятие`, project_name AS `название`, P.active AS `статус`
FROM `projects` P INNER JOIN `branch` B ON P.branch_id = B.branch_id';
        break;
    case 1:
    case 2:
    $data = "SELECT project_id AS `id`, project_name AS `название`, active AS `статус`
FROM `projects` WHERE branch_id = '$branch_id'";
        break;
}


echo template(display_data($connection->query($data), $options, ''));

