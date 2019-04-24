<?php
session_start();
echo $_SESSION['id'];
if (empty($_SESSION['id'])) header("Location: ./components/static/login.php");
include_once './static/template.php';
//include_once './bd/index.php';

//echo var_dump($_SESSION);

?>


<!DOCTYPE html>
<html>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRM</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">

<body>
<div class="main-page">
    <a href="components/main/logout.php">Logout</a>
</div>
</body>
</html>
