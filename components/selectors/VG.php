<?php
if (isset($_POST['vg_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $vg_id = clean($_POST['vg_id']);
    $vg_data = mysqli_fetch_assoc($connection->query("
            SELECT vg_id AS `id`, in_percent AS `in`, out_percent AS `out`, `name`, api_url_regexp AS url
            FROM virtualgood
            WHERE vg_id = '$vg_id'
            "));
    if ($vg_data) {
        echo json_encode($vg_data);
        return false;
    } else {
        echo "failed";
        return false;
    }
}
