<?php
include_once '../../../dev/ChromePhp.php';
if (isset($_POST['login']) && $_POST['password'] != 0) {

    return false;
}
<<<<<<< HEAD

if (isset($_POST['login'])) {

    return false;
}
=======
if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    ChromePhp::log("LOGIN");
}
$login = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];
ChromePhp::log("LOGIN: ", $login, "PASS: ", $password);
>>>>>>> cecc8068e69c9a87a63620bed1a472498ba8672e
