<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';


$options['type'] = 'VG';
$options['text'] = 'VG';
$options['edit'] = 2;
$options['btn'] = 2;
session_start();
//$options['btn-max'] = 2;
$options['btn-text'] = 'Добавить';

$data['vgs'] = $connection->query("
    SELECT * FROM virtualgood
");
if(iCan(3)){ // currently
    echo template(display_data($connection -> query('
SELECT branch_name AS предприятие, VG.vg_id AS id, VG.name AS название, in_percent As "покупка %", out_percent AS "продажа %", api_url_regexp AS "ссылка-шаблон", access_key AS "ключ доступа"
FROM virtualgood VG
INNER JOIN vg_data D ON VG.vg_id = D.vg_id
INNER JOIN branch B ON B.branch_id = D.branch_id
'), $options, $data));
}else{
    echo template(display_data($connection -> query('
SELECT VG.vg_id AS id, VG.name AS название, in_percent As "покупка %", out_percent AS "продажа %", api_url_regexp AS "ссылка-шаблон", access_key AS "ключ доступа"
FROM virtualgood VG
INNER JOIN vg_data D ON VG.vg_id = D.vg_id
INNER JOIN branch B ON B.branch_id = D.branch_id
WHERE B.branch_id = '.$_SESSION['branch_id'].'
'), $options, $data));
}

