<?php
if (isset($_POST['order_id']) &&
    isset($_POST['client_id']) &&
    isset($_POST['sum_vg']) &&
    isset($_POST['out']) &&
    isset($_POST['obtain']) &&
    isset($_POST['vg_id']) &&
    isset($_POST['shares'])&&
    isset($_POST['debt']) &&
    isset($_POST['callmaster']) &&
    isset($_POST['client_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    include_once "../../dev/ChromePhp.php";
    $rollback_1 = $_POST['rollback_1'] ? clean($_POST['rollback_1']) : 0;
    $rollback_2 = $_POST['rollback_2'] ? clean($_POST['rollback_2']) : 0;


}
