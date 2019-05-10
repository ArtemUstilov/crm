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
SELECT  concat(U.last_name, ' ', U.first_name) AS агент,  U.login AS 'логин агента', B.branch_name AS отдел, O.sum AS сума, IFNULL(concat(OW.last_name, ' ', OW.first_name),'-') AS владельцы, 
       IFNULL(description,'-') AS комментарий,
O.date AS дата
FROM outgo O
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN branch B ON B.branch_id = U.branch_id
LEFT JOIN (SELECT user_id AS owner_id, first_name, last_name FROM users WHERE is_owner = 1) OW ON OW.owner_id = O.user_as_owner_id
ORDER BY `date` DESC
");
        break;
    case 2:
        $info = $connection->query("
SELECT  concat(U.last_name, ' ', U.first_name) AS агент, U.login AS 'логин агента', O.sum AS сума, IFNULL(concat(OW.last_name, ' ', OW.first_name),'-') AS владельцы, IFNULL(description,'-') AS комментарий,
O.date AS дата
FROM outgo O
INNER JOIN users U ON U.user_id = O.user_id
LEFT JOIN (SELECT user_id AS owner_id, first_name, last_name FROM users WHERE is_owner = 1) OW ON OW.owner_id = O.user_as_owner_id
WHERE U.branch_id = '$branch_id'
ORDER BY `date` DESC
");
        break;
    case 1:
        $info = $connection->query('
SELECT O.sum AS сума, IFNULL(concat(OW.last_name, " ", OW.first_name),"-") AS владельцы, IFNULL(description,"-") AS комментарий,
O.date AS дата
FROM outgo O
INNER JOIN users U ON U.user_id = O.user_id
LEFT JOIN (SELECT user_id AS owner_id, first_name, last_name FROM users WHERE is_owner = 1) OW ON OW.owner_id = O.user_as_owner_id
WHERE O.user_id = ' . $_SESSION["id"] . '
ORDER BY `date` DESC
');
        break;
    default:
        exit();
        break;
}
$options['type'] = 'Outgo';
$options['text'] = 'История расходов';
$options['btn'] = 1;
$options['btn-text'] = 'Добавить';
echo template(display_data($info, $options, $connection->query('
SELECT user_id AS owner_id, concat(last_name, " ", first_name) AS name
FROM users
WHERE is_owner = 1 AND branch_id = ' . $branch_id . '
')));
?>

