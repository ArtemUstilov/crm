<?php
//$link = mysqli_connect(
//    "bpibcp34s7p5yps7ex4z-mysql.services.clever-cloud.com",
//    "uvnybryu3c2mrnfd",
//    "F2YCcnyMGPwwfrDfzB2w",
//    "bpibcp34s7p5yps7ex4z");

$link = mysqli_connect(
    "localhost",
    "root",
    "",
    "crm");
if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Соединение с MySQL установлено!" . PHP_EOL;
echo "Информация о сервере: " . mysqli_get_host_info($link) . PHP_EOL;

mysqli_close($link);
?>
