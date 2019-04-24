<?php
include_once './static/template.php';
include_once './db.php';
include_once './funcs.php';

echo template(display_data($connection -> query('
SELECT concat(last_name, " ", first_name) AS Имя, role AS должность, branch_name AS отделение
FROM users
'), 'Сотрудники'));
?>