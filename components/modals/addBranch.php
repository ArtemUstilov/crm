<?php

function branchAddModal($data)
{
$output = '
<div id="Branch-Modal" class="modal" action="" role="form">
    <form id="add-branch-form">
        <h2 class="modal-title">Добавить предприятие</h2>
        <div class="modal-inputs">
            <p>
            Название
                <input id="nameField" data-validation="required length" data-validation-length="min1" placeholder="Название" type="text" name="name">
            </p>
             <p>
  Деньги
  <input id="moneyField"    placeholder="Деньги" type="number" name="money" step="0.01">
  </p>
            </div>
            <input class="modal-submit" type="submit" value="Добавить">
            
    </form>
</div>
';
    session_start();
    if (iCan(2))
        $output .= '
<div id="Branch-edit-Modal" class="modal" action="" role="form">
    <form id="edit-branch-form">
        <h2 class="modal-title" id="edit-branch-title">Редактирова данные предприятия</h2>
        <div class="modal-inputs">
            <p>
            Название
                <input id="editNameField" data-validation="required length" data-validation-length="min1" placeholder="Название" type="text" name="name">
            </p>
       <p>
  Деньги
  <input id="editMoneyField"    placeholder="Деньги" type="number" name="money" step="0.01">
  </p>
            </div>
            <input class="modal-submit" type="submit" value="Сохранить">
    </form>
</div>';
return $output;
}