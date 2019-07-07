<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/funcs.php";
$curPage = substr($_SERVER['REQUEST_URI'], 1, -4);
?>
<div id="menu">
    <ul>
        <li>
            <a href="../.." class=' <?php (!$curPage ? '"active" disabled' : '') ?> '>Главная</a></li>
        <li><a href="../../content/clients.php" class='<?php ($curPage === ' clients' ? '"active" disabled' : '') ?>'>Клиенты</a>
        </li>
        <?php if (iCan(2))
            echo '
        <li><a href="../../content/owners.php" class=' . ($curPage === ' owners' ? '"active" disabled' : '') . '>Владельцы</a>
        </li>
        <li><a href="../../content/users.php" class=' . ($curPage === ' users' ? '"active" disabled' : '') .
                '>Сотрудники</a></li>';
        else echo '' ?>
        <?php if (iCan(3))
        echo '<li><a href="../../content/global.php" class=' . ($curPage === ' globalVG' ? '"active" disabled' : '') .'>Глобальное
                VG</a></li>
        <li><a href="../../content/fiats.php" class=' . ($curPage === ' fiats' ? '"active" disabled' : '') .'>Валюты</a>
        </li>
        <li><a href="../../content/branches.php"
               class='. ($curPage === ' branches' ? '"active" disabled' : '') .'>Предприятия</a></li>';
        else echo '' ?>
        <li><a href="../../content/vgs.php" class=' <?php ($curPage === ' vgs' ? '"active" disabled' : '') ?> '>VG</a>
        </li>
        <li><a href="../../content/orders.php" class=' <?php ($curPage === ' orders' ? '"active" disabled' : '') ?>'>Продажи</a>
        </li>
        <li><a href="../../content/outgo.php" class=' <?php ($curPage === ' outgo' ? '"active" disabled' : '') ?>'>Расходы</a>
        </li>
        <li><a href="../../content/referals.php"
               class=' <?php ($curPage === ' referals' ? '"active" disabled' : '') ?>'>Рефералы</a></li>
        <li><a href="../../content/debts.php" class=' <?php ($curPage === ' debts' ? '"active" disabled' : '') ?>'>Должники</a>
        </li>
        <li><a href="../../content/statistics.php"
               class=' <?php ($curPage === ' statistics' ? '"active" disabled' : '') ?>'>Статистика</a></li>
        <li><a href="../../content/turnover.php"
               class=' <?php ($curPage === ' turnover' ? '"active" disabled' : '') ?>'>Оборот</a></li>

        <li><a class="menu-logout-btn" href="../../api/auth/logout.php">Выйти</a></li>
    </ul>
</div>
