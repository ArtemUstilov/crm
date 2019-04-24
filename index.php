<?php
session_start();
if (empty($_SESSION['id'])) header("Location: ./login.php");
include_once './components/static/template.php';
echo template('');
