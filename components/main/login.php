<?php
session_start();
echo "not registered";
$_SESSION['id'] = 3;
header("Location: ../index.php");
