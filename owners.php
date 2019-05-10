<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
if(iCan(3)){
    $branches = $connection->query('
SELECT branch_id AS id, branch_name
FROM branch
');
    $table = $connection -> query('
        SELECT concat(O.last_name, " ", O.first_name) AS  Имя, branch_name AS предприятие
        FROM (SELECT user_id AS owner_id, first_name, last_name, branch_id FROM users WHERE is_owner = 1) O
        INNER JOIN branch B ON B.branch_id = O.branch_id
    ');
}else{
    $branches = $connection->query('
SELECT branch_id AS id, branch_name
FROM branch
WHERE branch_id = '.$_SESSION['branch_id'].'
');
    $table = $connection -> query('
        SELECT concat(O.last_name, " ", O.first_name) AS  Имя, branch_name AS предприятие
        FROM (SELECT user_id AS owner_id, first_name, last_name, branch_id FROM users WHERE is_owner = 1) O
        INNER JOIN branch B ON B.branch_id = O.branch_id
        WHERE B.branch_id = '.$_SESSION['branch_id'].'
    ');
}

$users = $connection->query('
SELECT *
FROM users
');
$data['branches'] = $branches;
$data['users'] = $users;
$options['type'] = 'Head';
$options['text'] = 'Владельцы';
$options['btn-text'] = 'Добавить';
$options['btn'] = 2;
echo template(display_data($table, $options, $data));

