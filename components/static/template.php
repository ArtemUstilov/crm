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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js"></script>
    <script>
        $(function(){$("#keywords").tablesorter();});
        $(window).load(function() {
            $(".spinner").fadeOut("slow");
        })
    </script>
</head>
<body>
' . menu() .'
<div class="spinner"></div>'.$body.'
<script src="./components/main/filter.js"></script>
</body>
</html>'
    );
}