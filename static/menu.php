<?php
function menu(){
    return ('<div id="menu">
    <ul>
        <li><a href="clients.php" <?php if($_GET[\'currentPage\'] == \'clients\') echo \'class="active"\'; ?>Клиенты</a></li>
        <li><a href="users.php" <?php if($_GET[\'currentPage\'] == \'users\') echo \'class="active"\'; ?>Сотрудники</a></li>
        <li><a href="orders.php" <?php if($_GET[\'currentPage\'] == \'orders\') echo \'class="active"\'; ?>Заказы</a></li>
    </ul>
</div>');
}