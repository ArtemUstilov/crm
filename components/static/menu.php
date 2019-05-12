<?php
function menu()
{
    include_once './funcs.php';
    $curPage = substr($_SERVER['REQUEST_URI'], 1, -4);
    return ('<div id="menu">
    <ul>
    <li>
    <a href="../../" class=' . (!$curPage ? '"active" disabled' : '') . '>Главная</a></li>
        <li><a href="../../clients.php" class=' . ($curPage === 'clients' ? '"active" disabled' : '') . '>Клиенты</a></li>
        '.(iCan(2) ? '
          <li><a href="../../owners.php" class=' . ($curPage === 'owners' ? '"active" disabled' : '') . '>Владельцы</a></li>
          <li><a href="../../users.php" class=' . ($curPage === 'users' ? '"active" disabled' : '') . '>Сотрудники</a></li>
        ' : '').'
        '.(iCan(3) ? '
        <li><a href="../../branches.php" class=' . ($curPage === 'branches' ? '"active" disabled' : '') . '>Предприятия</a></li>
        ' : '').'
        <li><a href="../../vgs.php" class=' . ($curPage === 'vgs' ? '"active" disabled' : '') . '>VG</a></li>
        <li><a href="../../orders.php" class=' . ($curPage === 'orders' ? '"active" disabled' : '') . '>Продажи</a></li>
        <li><a href="../../outgo.php" class=' . ($curPage === 'outgo' ? '"active" disabled' : '') . '>Расходы</a></li>
        <li><a href="../../referals.php" class=' . ($curPage === 'referals' ? '"active" disabled' : '') . '>Рефералы</a></li>
        <li><a href="../../debts.php" class=' . ($curPage === 'debts' ? '"active" disabled' : '') . '>Должники</a></li>
        <li><a href="../../statistics.php" class=' . ($curPage === 'statistics' ? '"active" disabled' : '') . '>Статистика</a></li>
        <li><a href="../../turnover.php" class=' . ($curPage === 'turnover' ? '"active" disabled' : '') . '>Оборот</a></li>

        <li>    <a class="menu-logout-btn" href="./components/auth/logout.php">Выйти</a></li>
    </ul>
</div>');
}