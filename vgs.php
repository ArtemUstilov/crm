<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

echo template(display_data($connection -> query('
SELECT name AS название, in_percent As "покупка %", out_percent AS "продажа %", api_url_regexp AS "ссылка-шаблон"
FROM virtualgood
'),"VG", "VG"));
?>