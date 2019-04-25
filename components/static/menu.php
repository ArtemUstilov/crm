<?php
function menu(){
    $curPage = substr($_SERVER['REQUEST_URI'],1,-4);
    return ('<div id="menu">
    <ul>
    <li><a href="../../" class='.($curPage === '' ? '"active" disabled' : '').'>Главная</a></li>
         <li><a href="../../users.php" class='.($curPage === 'users' ? '"active" disabled' : '').'>Сотрудники</a></li>
        <li><a href="../../clients.php" class='.($curPage === 'clients' ? '"active" disabled' : '').'>Клиенты</a></li>
        <li><a href="../../orders.php" class='.($curPage === 'orders' ? '"active" disabled' : '').'>Заказы</a></li>
        <li><a href="./components/main/logout.php">Выйти</a></li>
    </ul>
</div>');
}