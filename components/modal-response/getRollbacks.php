<?php
if (isset($_POST['client_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $client_id = clean($_POST['client_id']);
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("
        SELECT * 
        FROM users 
        WHERE user_id='$user_id'"));
    if (!$user_data) return false;
    

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

