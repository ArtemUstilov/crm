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
            <input class="add-modal-submit" type="submit" value="Добавить">
    </form>
</div>';
return $output;
}