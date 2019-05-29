<?php
include_once '../../../dev/ChromePhp.php';
if (isset($_SERVER['PHP_AUTH_USER'])) {
    ChromePhp::log($_SERVER);
}
if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    ChromePhp::log("LOGIN");
}
$login = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];
ChromePhp::log("LOGIN: ", $login, "PASS: ", $password);
