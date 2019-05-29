<?php

echo '
<head>
    <title>gCRM</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<p id="debt-limit-label"></p>
<p id="sum-label"></p>
<p id="vg-label"></p>
    <input id="login" type="text" placeholder="login" name="login">
    <div id="pass-box" style="display: none">
    <input id="pass" type="password" placeholder="password" name="password" >
    <button type="button" id="pass-btn">Подтвердить пароль</button>
    </div>
    <p style="display: none;">
        <select id="vg-types">
            <option value selected disabled>Выберите вг</option>
        </select>
    </p>
    <input id="vg-sum" type="number" placeholder="Количество">
    <p style="display: none;">К оплате: <span id="fiat-sum">0.0</span> грн</p>
    <button id="login-btn" type="button">Войти</button>
    <button id="pay-in-debt-btn" type="button" style="display: none;">Взять в долг</button>
    <button id="pay-system-btn" type="button" style="display: none;">Купить</button>
    <script src="./js/scripts.js"></script>
</body>
';