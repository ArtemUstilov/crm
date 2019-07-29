<?php
$connection = mysqli_connect(
    "localhost",
    "root",
    "",
    'crm100500');

//$connection = mysqli_connect("localhost", "gcrm1", "9834cm9834ME", "dev_gcrm");


mysqli_query($connection, "SET NAMES 'utf8'");
mysqli_query($connection, "SET CHARACTER SET 'utf8'");


