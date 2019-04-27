<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

echo template(display_data($connection -> query('
SELECT O.sum AS сума, concat(OW.last_name, " ", OW.first_name) AS head,
O.date AS дата
FROM outgo O
INNER JOIN users U ON U.user_id = O.user_id
LEFT JOIN owners OW ON OW.owner_id = O.owner_id
WHERE O.user_id = '.$_SESSION["id"].'
'), "Outgo","История расходов", $connection->query('
SELECT owner_id, concat(last_name, " ", first_name) AS name
FROM owners
WHERE branch_id IN (SELECT branch_id FROM users WHERE user_id = '.$_SESSION["id"].')
')));
?>

