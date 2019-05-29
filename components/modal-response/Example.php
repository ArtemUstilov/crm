if (strpos($vg_data['url'],'%key%')) {
$IDTransact = generateRandomString();
$vg_url = strtolower($vg_data['url']);
$vg_url = str_replace("%username%", $login_by_vg, $vg_url);
$vg_url = str_replace("%sum%", $sum_vg, $vg_url);
$vg_url = str_replace("%idtransact%", $IDTransact, $vg_url);
$vg_url = str_replace("%key%", $vg_data['key'], $vg_url);
$vg_url = str_replace("%clientlogin%", $login_by_vg, $vg_url);
$md5 = md5($vg_url);
$vg_url = str_replace("%md5hash%", $md5, $vg_url);
} else {
$vg_url = str_replace("%username%", $login_by_vg, $vg_data['url']);
$vg_url = str_replace("%summ%", $sum_vg, $vg_url);
}
set_error_handler(
function ($severity, $message, $file, $line) {
throw new ErrorException($message, $severity, $severity, $file, $line);
}
);

try {
$result = json_decode(file_get_contents($vg_url));

if($result->{'success'} == false){
$result->{'url'} = $vg_url;
echo json_encode($result);
return false;
}
} catch (Exception $e) {
$response['url'] = $vg_url;
$response['success'] = false;
echo json_encode($response);
return false;
}

restore_error_handler();