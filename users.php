<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

echo template(display_data($connection -> query('
SELECT concat(last_name, " ", first_name) AS Имя, role AS должность, branch_name AS отделение
FROM users
'),"User","Сотрудники"));
?>