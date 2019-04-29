<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';

echo template(display_data($connection -> query('
SELECT concat(C.last_name, " ", C.first_name) AS клиент, 
O.debt_sum AS сума,
O.date AS дата
FROM debt_history O
INNER JOIN clients C ON C.client_id = O.client_id 
INNER JOIN users U ON U.user_id = O.user_id
WHERE O.user_id = '.$_SESSION["id"].'
'), "Debt","История погашений долгов", $connection -> query('
SELECT DISTINCT concat(last_name, " ", first_name) AS client_name, 
byname AS login, debt
FROM clients C
INNER JOIN orders O ON C.client_id = O.client_id
WHERE  debt > 0 AND O.user_id = '.$_SESSION["id"].'
')));

