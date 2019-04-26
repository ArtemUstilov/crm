<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

echo template(display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS клиент, 
O.sum AS сума, O.owner AS head,
O.date AS дата
FROM outgo O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
WHERE O.user_id = '.$_SESSION["id"].'
'), "Расходы"));
?>

