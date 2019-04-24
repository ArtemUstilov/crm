<?php
//session_start();
//$_SESSION['id'] = 3;
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRM</title>
<link href="../../css/style.css" rel="stylesheet" type="text/css">

<body>
<div class="login-page">
    <form method="post" action="../main/auth.php" class="login-form">
        <h2 class="login-form-header">Sign in</h2>
        <div class="login-box">
            <input id="loginField" placeholder="Login" type="text" name="login">
        </div>
        <div class="pass-box">

                <input id="passwordField" placeholder="Password" type="text" name="password">
        </div>
        <div class="sign-in-box">
            <label class="container">Remember me
                <input type="checkbox">
                <span class="checkmark"></span>
            </label>
            <button type="submit" class="login-form-submit">Sign in</button>
        </div>
    </form>
</div>
</body>
</html>
