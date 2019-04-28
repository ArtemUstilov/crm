<?php
if (isset($_POST['id'])) {
    include_once("../../dev/ChromePhp.php");
    include_once("../../db.php");
    include_once("../../funcs.php");
    $id = clean($_POST['id']);
    session_start();
    $user_id = $_SESSION['id'];
    $branch_name = $_SESSION['branch'];
    $user_data = mysqli_fetch_assoc($connection->query("SELECT * FROM users WHERE user_id='$user_id'"));
    if (!$user_data) return false;
    $branch_id = mysqli_fetch_assoc($connection->query("SELECT branch_id AS id FROM branch WHERE branch_name = '$branch_name'"))['id'];
    $all_owners_data = $connection->query("SELECT concat(last_name, ' ', first_name) AS owner_name, owner_id AS id 
    FROM owners WHERE branch_id = '$branch_id'");
    $last_order = mysqli_fetch_assoc($connection->query("SELECT order_id AS id FROM orders WHERE `date` IN (SELECT MAX(`date`) AS `date` FROM orders WHERE vg_id = '$id' AND user_id IN (SELECT user_id 
    FROM users WHERE branch_id = '$branch_id') )"))['id'];
    $owners_data = $connection->query("SELECT concat(last_name, ' ', first_name) AS owner_name, shares.owner_id AS id, share_percent AS percent 
FROM owners INNER JOIN shares ON shares.owner_id = owners.owner_id WHERE order_id='$last_order'");

    $i = 0;
    while ($new = $owners_data->fetch_array()) {
        $owners[$i] = $new;
        $i++;
    }
    $i = 0;
    while ($new = $all_owners_data->fetch_array()) {
        $all_owners[$i] = $new;
        $i++;
    }
    if (!$owners) {
        echo "empty";
        return false;
    }
    $i = 0;
    foreach ($all_owners as $key => $var1) {
        foreach ($owners as $key => $var2) {
            if ($var1['id'] != $var2['id']) {
                $invisible_owners[$i] = $var1;
                $i++;
            }
        }
    }
    $res = '<div id="owners-list-visible" class="orders-modal-owners-list">';
    foreach ($owners as $key => $var) {
        $res .= '<p>' . $var["owner_name"] . '<input class="owner-percent-input" type="number" owner-id="' . $var['id'] . '"placeholder="Процент прибыли" value="' . $var["percent"] . '"></p>';
    }
    $res .= '</div>';

    $res .= '<div id="owners-list-invisible" class="orders-modal-owners-list">';
    foreach ($invisible_owners as $key => $var) {
        $res .= '<p>' . $var["owner_name"] . '<input class="owner-percent-input" type="number" owner-id="' . $var['id'] . ' placeholder="Процент прибыли" ></p>';
    }
    $res .= '</div>';
    echo $res;

}

