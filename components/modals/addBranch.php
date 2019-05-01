<?php

function branchAddModal($data)
{
$output = '
<div id="Branch-Modal" class="modal" action="" role="form">
    <form id="add-branch-form">
        <h2 class="add-modal-title">Добавить предприятие</h2>
        <div class="add-modal-inputs">
            <p>
                <input id="nameField" data-validation="required length" data-validation-length="min1" placeholder="Название" type="text" name="name">
            </p>
            </div>
            <input class="add-modal-submit" type="submit" value="Добавить">
            
    </form>
</div>
';
    session_start();
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moder')
        $output .= '
<div id="Branch-edit-Modal" class="modal" action="" role="form">
    <form id="edit-branch-form">
        <h2 class="edit-modal-title" id="edit-branch-title">Редактирова данные предприятия</h2>
        <div class="edit-modal-inputs">
            <p>
            Название
                <input id="editNameField" data-validation="required length" data-validation-length="min1" placeholder="Название" type="text" name="name">
            </p>
            </div>
            <input class="edit-modal-submit" type="submit" value="Добавить">
    </form>
</div>';
return $output;
}