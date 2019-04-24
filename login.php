<?php
//session_start();
//$_SESSION['id'] = 3;
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/listeners.js"></script>
<title>CRM</title>
<link href="css/style.css" rel="stylesheet" type="text/css">

<body>
<div class="login-page">
    <form class="login-form" id="login-form">
        <h2 class="login-form-header">Sign in</h2>
        <div class="login-box">
            <input id="loginField" placeholder="Логин" type="text" name="login">
        </div>
        <div class="pass-box">

            <input id="passwordField" placeholder="Пароль" type="password" name="password">
        </div>
         <div class="sign-in-box">
             <!--
             <label class="container">Запомнить меня
                 <input type="checkbox" id="remember-me-check">
                 <span class="checkmark"></span>
             </label> -->
        <button type="submit" class="login-form-submit">Sign in</button>
</div>
</form>
</div>
</body>
</html>
