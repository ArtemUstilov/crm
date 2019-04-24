<?php
include_once ('funcs.php');
if (!isAuthorized()) header("Location: ./login.php");
include_once './components/static/template.php';
echo template(null);
