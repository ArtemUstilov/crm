<?php
include_once './components/static/menu.php';
function template($body)
{
    return (
        '<html>
<head>
    <title>...</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="../../js/listeners.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js"></script>
    <script>
        $(function(){$("#table-container").tablesorter();});
        $(window).load(function() {
            $(".spinner").fadeOut("slow");
            
        })
    </script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

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
<script src="./js/filter.js"></script>
</body>
</html>'
    );
}