<?php
function menu(){
    $curPage = substr($_SERVER['REQUEST_URI'],1,-4);

    return ('<div id="menu">
    <ul>
    <li><a href="../../" class='.(!$curPage ? '"active" disabled' : '').'>Главная</a></li>
         <li><a href="../../users.php" class='.($curPage === 'users' ? '"active" disabled' : '').'>Сотрудники</a></li>
        <li><a href="../../clients.php" class='.($curPage === 'clients' ? '"active" disabled' : '').'>Клиенты</a></li>
         <li><a href="../../vgs.php" class='.($curPage === 'vgs' ? '"active" disabled' : '').'>VG</a></li>
        <li><a href="../../orders.php" class='.($curPage === 'orders' ? '"active" disabled' : '').'>Продажи</a></li>
                <li><a href="../../outgo.php" class='.($curPage === 'outgo' ? '"active" disabled' : '').'>Расходы</a></li>
        <li><a href="../../referals.php" class='.($curPage === 'referals' ? '"active" disabled' : '').'>Рефералы</a></li>
        <li><a href="../../debts.php" class='.($curPage === 'debts' ? '"active" disabled' : '').'>Долги</a></li>
        <li><a href="./components/main/logout.php">Выйти</a></li>
    </ul>
</div>');
}