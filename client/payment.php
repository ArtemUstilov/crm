<?php

echo '
<head>
    <title>gCRM</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
    <p>
        <select id="vg-types">
            <option value selected disabled>Выберите вг</option>
        </select>
    </p>
     <p>
        <input id="vg-sum" type="number" placeholder="Количество">
    </p>
    <p>К оплате: <span id="fiat-sum">0.0</span> грн</p>
    <script src="./js/scripts.js"></script>
</body>
';