<?php
function orderAddModal($data, $more_data)
{
    session_start();

    $id = $_SESSION['id'];
    $output = '
<div id="Order-Modal" class="modal" action="" role="form">
<form id="add-order-form">
  <h2 class="add-modal-title">Добавить продажу</h2>
  <div class="add-modal-inputs">
  <p>
  Клиент
<select id="clientField" data-validation="required">
  <option value="" disabled selected>Выберите клиента</option>';
    foreach ($more_data['clients'] as $key => $var) {
        $output .= '<option value="' . $var["id"] . '">' . $var["name"] . '</option>';
    }
    $output .= '
    <option value="-1">Добавить нового</option>;
  </select>
</p>
<p>
ВГ
<select id="vgField" data-validation="required"><option value="" disabled selected>Выберите валюту</option>';
    foreach ($more_data['vgs'] as $key => $var) {
        $output .= '<option percent="' . $var["out_percent"] . '" value="' . $var['vg_id'] . '">' . $var['name'] . '</option>';
    }
    $output .= '
</select>
</p>
  <p>
  Сумма вг
  <input id="sumVGField" data-validation="required length" data-validation-length="min1" placeholder="Кол-во виртуальной валюты" type="number" name="sum-vg" step="1000">
  </p>
   <p>
   Не оплаченая часть
  <input id="debtClField" data-validation="required length" data-validation-length="min1" type="number" name="debt-sum" value = 0>
  </p>
  <p>
  Реферал
<select id="callmasterField">
  <option value="" selected>Выберите реферала(опц)</option>';
    foreach ($more_data['clients'] as $key => $var) {
        $output .= '<option value="' . $var["id"] . '">' . $var["name"] . '</option>';
    }
    $output .= '
    <option value="-1">Добавить нового</option>;
  </select>
</p>

  <p>
  Продажа
  <input id="outField" data-validation="required length" data-validation-length="min1" placeholder="Продажа %" type="number" name="out">
  </p>
    <p>
  <select id="obtainingField" data-validation="required">
  <option value="" disabled selected>Способ получения</option>;
  <option value="card">На карту</option>;
  <option value="cash">Наличные</option>;
  </select>
  </p>
   </div><div id="owners-lists-container"></div>
   <div id="rollbacks-lists-container" class="add-modal-inputs" style="display: none">
<p>
   Откат 1
  <input id="rollback1Field" placeholder="Откат 1 %" type="number" name="rollback-1" step="0.01">
  </p>
  <p>
  Откат 2
  <input id="rollback2Field"  placeholder="Откат 2 %" type="number" name="rollback-2" step="0.01">
  </p>
  </div>
  <input class="add-modal-submit" type="submit" value="Оформить">
  </form>
</div>';

    return $output;
}
