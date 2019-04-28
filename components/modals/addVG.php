<?php
function vgAddModal($data)
{
    $output = '
<div id="VG-Modal" class="modal" action="" role="form">
<form id="add-vg-form">
  <h2 class="add-modal-title">Добавить валюту</h2>
  <div class="add-modal-inputs">
  <p>
  <input id="nameField" data-validation="required length" data-validation-length="min1" placeholder="Название" type="text" name="name">
  </p>
  <p>
  <input id="inField" data-validation="required length" data-validation-length="min1" placeholder="покупка %" type="number" name="in">
  </p>
  <p>
  <input id="outField" data-validation="required length" data-validation-length="min1" placeholder="продажа %" type="number" name="out">
  </p>
   <p>
  <input id="urlField" data-validation="required length" data-validation-length="min4" placeholder="url" type="url" name="url">
  </p>
  </div>
  <input class="add-modal-submit" type="submit" value="Добавить">
  </form>
</div>';

    return $output;
}
