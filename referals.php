<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

echo template(display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS клиент, 
O.rollback_sum AS сума,
O.date AS дата
FROM rollback_paying O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
WHERE O.user_id = '.$_SESSION["id"].'
'), "Rollback","Рефералы", $connection -> query('
SELECT concat(last_name, " ", first_name) AS client_name, 
byname AS login
FROM clients
WHERE  rollback_sum > 0
')));
?>

