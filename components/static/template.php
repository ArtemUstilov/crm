<?php
include_once './components/static/menu.php';
function template($body)
{
    return (
        '<html>
<head>
    <title>...</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../../style.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="../../js/listeners.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js"></script>
    <script>
        $(function(){$("#keywords").tablesorter();});
        $(window).load(function() {
            $(".spinner").fadeOut("slow");
            
        })
    </script>
</head>
<body>
<div class="main-header">
<div id="menu-burger" class="menu-burget-btn"></div>
<div class="account-name-menu-btn-box">
<p id="username">' . $_SESSION['name'] . '</p>
</div>
</div>
<div class="main-wrapper">
' . menu() . '
<div class="spinner"></div>' . ($body ? $body : '<h1>NO INFO ABOUT CURRENT PAGE</h1>') . '
</div>
<script src="./components/main/filter.js"></script>
</body>
</html>'
    );
}