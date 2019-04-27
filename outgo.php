<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

echo template(display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS клиент, 
O.sum AS сума, concat(OW.last_name, " ", OW.first_name) AS head,
O.date AS дата
FROM outgo O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
INNER JOIN owners OW ON OW.owner_id = O.owner_id
WHERE O.user_id = '.$_SESSION["id"].'
'), "Outgo","История расходов"));
?>

