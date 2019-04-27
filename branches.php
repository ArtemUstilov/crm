<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

echo template(display_data($connection -> query('
SELECT branch_name
FROM branch'), "Branch","Предприятия"));

