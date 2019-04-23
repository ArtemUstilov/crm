<?php
include_once './db/index.php';
session_start();
if(empty($_SESSION['id']))header("Location: ./components/main/login.php");
echo var_dump($_SESSION);
