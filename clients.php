<?php
include_once './funcs.php';
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
include_once './db.php';
$options['text'] = 'Клиенты';
$options['type'] = 'Client';
$options['edit'] = 1;
$options['info'] = true;
$options['btn-max'] = 2;
$options['btn-text'] = 'Добавить';
$options['btn'] = 1;
session_start();
switch(accessLevel()){
    case 3:
        $clients = $connection->query('
                    SELECT client_id AS id, concat(last_name, " ", first_name) AS "Полное имя",
                           byname AS Имя, IFNULL(phone_number, "-") AS телефон,
                           email AS почта, IFNULL(telegram, "-") AS телеграм
                    FROM clients C
                    ');
        break;
    case 2:
        $clients = $connection->query('
                    SELECT DISTINCT C.client_id AS id, concat(C.last_name, " ", C.first_name) AS "Полное имя",
                                    C.byname AS Имя, IFNULL(phone_number, "-") AS телефон,
                                    C.email AS почта, IFNULL(telegram, "-") AS телеграм
                    FROM clients C
                    WHERE user_id IN (
                        SELECT user_id FROM users WHERE branch_id = '.$_SESSION['branch_id'].'
                    )
                    ');
        break;
    case 1:
        $clients = $connection->query('
                    SELECT DISTINCT C.client_id AS id, concat(C.last_name, " ", C.first_name) AS "Полное имя",
                                    C.byname AS Имя, IFNULL(phone_number, "-") AS телефон, C.email AS почта, IFNULL(telegram, "-") AS телеграм
          FROM clients C
                    WHERE user_id = '.$_SESSION['id'].'
                    ');
}
echo template(display_data($clients, $options));
?>
