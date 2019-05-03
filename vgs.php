<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

$options['type'] = 'VG';
$options['text'] = 'VG';
$options['edit'] = 2;
$options['btn'] = 2;
$options['btn-text'] = 'Добавить';
echo template(display_data($connection -> query('
SELECT vg_id AS id, name AS название, in_percent As "покупка %", out_percent AS "продажа %", api_url_regexp AS "ссылка-шаблон"
FROM virtualgood
'), $options));
?>