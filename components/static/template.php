<?php
include_once './components/static/menu.php';
function template($body)
{
    switch (accessLevel()) {
        case 3:
            $changeBranch = '<div id="Change-Branch-Modal" class="modal" >
<h2 class="modal-title">Перейти в другой отдел</h2>
<form id="change-branch-form">
<div class="modal-inputs">
<p>
<select data-validation="required" id="changeBranchField">
</select>
</p>
</div>
<input class="modal-submit" type="submit" value="Перейти">
</form>

</div>
<script src="./js/changeBranch.js"></script>';
            $userIcon = 'user-shield';
            break;
        case 2:
            $changeBranch = '';
            $userIcon = 'user-cog';
            break;
        default:
            $changeBranch = '';
            $userIcon = 'user';
    }
    return (
        '<html>
<head>
    <title>CRM</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/style.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script>
        $(function(){$(".table-container").tablesorter();});
        $(window).load(function() {
            $(".loader").fadeOut("slow");
            
        });
    </script>
</head>
<body>
<div class="custom-alert">
<div class="alert-text-box"></div>
<div class="close-btn-box"> <i class="fa fa-chevron-right"></i></div>
</div>
<div class="main-header">
<div id="menu-burger" class="menu-burget-btn">
<i class="fas fa-bars fa-2x"></i>
</div>
<div class="account-name-menu-btn-box">
<i class="fas fa-building fa-2x"></i>
<p class="menu-n" id="branch-t">' . $_SESSION['branch'] . '</p>
</div>
<div class="account-name-menu-btn-box">
<i class="fas fa-coins fa-2x"></i>
</div>
<div id="logout" class="account-name-menu-btn-box">
<i class="fas fa-' . $userIcon . ' fa-2x"></i>
<p class="menu-n">' . $_SESSION['name'] . '</p>
<a  href="./components/auth/logout.php"><i class="fas fa-sign-out-alt fa-2x"></i></a>
</div>
</div>
<a href="#Branch-money-info-modal" rel="modal:open" style="display: none"></a>
<div id="Branch-money-info-modal" class="modal">

</div>
<div class="main-wrapper">
' . menu() . '
<div class="loader"><div class="spinner"></div></div><div id="wrapper">' . ($body ? $body : '<h1>NO INFO ABOUT CURRENT PAGE</h1>') . '</div>
</div>
' . $changeBranch . '
<script src="./js/add-handlers.js"></script>
<script src="./js/edit-handlers.js"></script>
<script src="./js/edit.js"></script>
<script src="./js/listeners.js"></script>
</body>
</html>'
    );
}