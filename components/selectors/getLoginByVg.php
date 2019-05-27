<?php
include_once("../../db.php");
include_once("../../funcs.php");
$client_id = clean($_GET['client_id']);
$vg_id = clean($_GET['vg_id']);
$res = $connection->query("SELECT loginByVg FROM orders WHERE client_id = '$client_id' AND vg_id = '$vg_id' ORDER BY `date` DESC LIMIT 1");
if($res){
    $res = mysqli_fetch_assoc($res)['loginByVg'];
    echo json_encode(array("loginByVg"=>$res));
    return false;
}
echo json_encode(array("loginByVg"=>null));
return false;
