<?php
function menu(){
    $curPage = substr($_SERVER['REQUEST_URI'],1,-4);
    return ('<div id="menu">
    <ul>
        <li><p id="username">'.$_SESSION['name'].'</p></li>
        <li><a href="./components/main/logout.php">Выйти</a></li>
        <li><a href="../../clients.php" class="'.($curPage === 'clients' ? 'active' : '').'">Клиенты</a></li>
        <li><a href="../../users.php" class="'.($curPage === 'users' ? 'active' : '').'">Сотрудники</a></li>
        <li><a href="../../orders.php" class="'.($curPage === 'orders' ? 'active' : '').'">Заказы</a></li>
    </ul>
</div>');
}