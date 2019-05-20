<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
session_start();
$branch_name = $_SESSION['branch'];
$branch_id = $_SESSION['branch_id'];
switch (accessLevel()) {
    case 3:
        $info = $connection->query("
SELECT  concat(U.last_name, ' ', U.first_name) AS `агент`, F.full_name AS `валюта`, U.login AS 'логин агента', B.branch_name AS `отдел`, concat(O.sum, ' ', F.name) AS `сумма`, IFNULL(concat(OW.last_name, ' ', OW.first_name),'-') AS `владельцы`, 
       IFNULL(description,'-') AS `комментарий`,
O.date AS `дата`
FROM outgo O
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN branch B ON B.branch_id = U.branch_id
    INNER JOIN fiats F ON F.fiat_id = O.fiat_id
LEFT JOIN (SELECT user_id AS `owner_id`, first_name, last_name FROM users WHERE is_owner = 1) OW ON OW.owner_id = O.user_as_owner_id
ORDER BY `date` DESC
");
        break;
    case 2:
    case 1:
        $info = $connection->query("
SELECT  concat(U.last_name, ' ', U.first_name) AS `агент`, F.full_name AS `валюта`, U.login AS 'логин агента', concat(O.sum, ' ', F.name) AS `сумма`, IFNULL(concat(OW.last_name, ' ', OW.first_name),'-') AS `владельцы`, IFNULL(description,'-') AS `комментарий`,
O.date AS `дата`
FROM outgo O
INNER JOIN users U ON U.user_id = O.user_id
    INNER JOIN fiats F ON F.fiat_id = O.fiat_id
LEFT JOIN (SELECT user_id AS `owner_id`, first_name, last_name FROM users WHERE is_owner = 1) OW ON OW.owner_id = O.user_as_owner_id
WHERE U.branch_id = '$branch_id'
ORDER BY `date` DESC
");
        break;
//    case 1:
//        $info = $connection->query('
//SELECT concat(O.sum, \' \', F.name) AS `сумма`, F.full_name AS `валюта`, IFNULL(concat(OW.last_name, " ", OW.first_name),"-") AS `владельцы`, IFNULL(description,"-") AS `комментарий`,
//O.date AS `дата`
//FROM outgo O
//INNER JOIN users U ON U.user_id = O.user_id
//INNER JOIN fiats F ON F.fiat_id = O.fiat_id
//LEFT JOIN (SELECT user_id AS `owner_id`, first_name, last_name FROM users WHERE is_owner = 1) OW ON OW.owner_id = O.user_as_owner_id
//WHERE O.user_id = ' . $_SESSION["id"] . '
//ORDER BY `date` DESC
//');
//        break;
    default:
        exit();
        break;
}
$data['fiats'] = $connection->query("
SELECT * FROM fiats
");
$data['clients'] = $connection->query('
SELECT user_id AS `owner_id`, concat(last_name, " ", first_name) AS `name`
FROM users
WHERE is_owner = 1 AND branch_id = ' . $branch_id . '
');
$options['type'] = 'Outgo';
$options['text'] = 'История расходов';
$options['btn'] = 1;
$options['btn-max'] = 2;
$options['btn-text'] = 'Добавить';
echo template(display_data($info, $options, $data));
?>

