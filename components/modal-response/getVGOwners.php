<?php
if (isset($_POST['vg_id']) && isset($_POST['client_id'])) {
    include_once("../../dev/ChromePhp.php");
    include_once("../../db.php");
    include_once("../../funcs.php");
    $vg_id = clean($_POST['vg_id']);
    $client_id = clean($_POST['client_id']);
    session_start();
    $user_id = $_SESSION['id'];
    $branch_name = $_SESSION['branch'];
    $user_data = mysqli_fetch_assoc($connection->query("
        SELECT * 
        FROM users 
        WHERE user_id='$user_id'"));
    if (!$user_data) return false;

    $branch_id = $user_data['branch_id'];

    $last_order = mysqli_fetch_assoc($connection->query("
    SELECT order_id
    FROM orders
    WHERE client_id='$client_id' AND vg_id='$vg_id'
    ORDER BY `date` DESC
    LIMIT 1
   "))['order_id'];

    $prev_order_owners = mysqliToArray($connection->query("
        SELECT concat(last_name, ' ', first_name) AS owner_name, shares.owner_id AS id, share_percent AS percent 
        FROM owners 
        INNER JOIN shares ON shares.owner_id = owners.owner_id 
        WHERE order_id='" . $last_order . "' AND branch_id = '" . $branch_id . "'
    "));

    $hidden_owners = mysqliToArray($connection->query("
        SELECT concat(last_name, ' ', first_name) AS owner_name, owner_id AS id 
        FROM owners 
        WHERE branch_id = '$branch_id' AND owner_id NOT IN (
            SELECT shares.owner_id 
            FROM owners 
            INNER JOIN shares ON shares.owner_id = owners.owner_id 
            WHERE order_id='" . $last_order . "')"
    ));

    if (!$prev_order_owners) {
        $res .= '<div id="owners-list-visible" class="orders-modal-owners-list">';
        if ($hidden_owners) foreach ($hidden_owners as $key => $var) {
            $res .= '
            <p>' . $var["owner_name"] . '
            <input 
                class="owner-percent-input" 
                type="number" 
                owner-id="' . $var['id'] . '" 
                placeholder="Процент прибыли" 
                value="' . (!$prev_order_owners ? sprintf('%0.2f', 100.0 / count($hidden_owners)) : 0) . '">
            </p>
        ';
        }
        $res .= '</div>';
        echo $res;
        return false;
    }
    $res = '';

    $res .= '<div id="owners-list-visible" class="orders-modal-owners-list">';
    if ($prev_order_owners) foreach ($prev_order_owners as $key => $var) {
        $res .= '
            <p>' . $var["owner_name"] . '
            <input 
                class="owner-percent-input" 
                type="number" owner-id="' . $var['id'] . '" 
                placeholder="Процент прибыли" 
                value="' . $var["percent"] . '">
            </p>
        ';
    }
    $res .= '</div><div id="open-invisible-owner-list">Показать всех</div>';

    $res .= '<div id="owners-list-invisible" class="orders-modal-owners-list">';
    if ($hidden_owners) foreach ($hidden_owners as $key => $var) {
        $res .= '
            <p>' . $var["owner_name"] . '
            <input 
                class="owner-percent-input" 
                type="number" 
                owner-id="' . $var['id'] . '" 
                placeholder="Процент прибыли" 
                value="' . (!$prev_order_owners ? sprintf('%0.2f', 100.0 / count($hidden_owners)) : 0) . '">
            </p>
        ';
    }
    $res .= '</div>';
    echo $res;

}

