<?php
function outgoModal($data, $more_data)
{
    $output = '
<div id="Outgo-Modal" class="modal" action="" role="form">
<form id="add-outgo-form">
  <h2 class="modal-title">Добавить расходы</h2>
  <div class="modal-inputs">
   <p>
  <input id="sumField" min=0 data-validation="required" placeholder="Сумма" type="number" name="sum">
  </p>
  <p>
  <select id="ownerField">
  <option value="" selected disabled>Выберите владельца (опц)</option>';
    foreach ($more_data as $key => $var) {
        $output .= '<option value="' . $var['owner_id'] . '">' . $var['name'] . '</option>';
    }
    $output .= '
</select>
</p>
  </div>
  <input class="modal-submit" type="submit" value="Добавить">
  </form>
</div>';

    return $output;
}