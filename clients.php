<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$options['text'] = 'Клиенты';
$options['type'] = 'Client';
$options['edit'] = 1;
$options['btn-text'] = 'Добавить';
$options['btn'] = 1;
switch(accessLevel()){
    case 3:
        $clients = $connection->query('
                    SELECT client_id AS id, concat(last_name, " ", first_name) AS "Полное имя", byname AS Имя, phone_number AS телефон, debt AS долг, rollback_sum AS откат, email AS почта
                    FROM clients
                    ');
        break;
    case 2:
    case 1:
        $clients = $connection->query('
                    SELECT DISTINCT C.client_id AS id, concat(C.last_name, " ", C.first_name) AS "Полное имя", C.byname AS Имя, phone_number AS телефон, C.debt AS долг, C.rollback_sum AS откат, C.email AS почта
                    FROM clients C
                    INNER JOIN orders O ON O.client_id = C.client_id
                    WHERE O.user_id = '.$_SESSION['id'].'
                    ');
}
echo template(display_data($clients, $options));
?>
