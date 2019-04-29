<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
session_start();
$branch_id = $_SESSION['branch_id'];
switch ($_SESSION['role']) {
    case "admin":
        $res = ($connection->query('
SELECT concat(last_name, " ", first_name) AS Имя, role AS должность, branch_name AS отделение
FROM users U
INNER JOIN branch B ON B.branch_id = U.branch_id
'));
        break;
    case "moder":
        $res = ($connection->query("
SELECT concat(last_name, ' ', first_name) AS Имя, role AS должность, branch_name AS отделение
FROM users U
INNER JOIN branch B ON B.branch_id = U.branch_id
WHERE B.branch_id = '$branch_id' AND role!= 'admin'
"));
        break;
    case "agent":
        $res = ($connection->query("
SELECT concat(last_name, ' ', first_name) AS Имя, branch_name AS отделение
FROM users U
INNER JOIN branch B ON B.branch_id = U.branch_id
WHERE B.branch_id = '$branch_id' AND role!= 'admin'
"));
        break;
    default:
        exit();
        break;
}

echo template(display_data($res, "User", "Сотрудники", $connection->query('
SELECT * FROM branch
')));
?>