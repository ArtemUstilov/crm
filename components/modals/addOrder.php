<?php
function orderAddModal($data, $more_data)
{
    $output = '
<div id="Order-Modal" class="modal" action="" role="form">
<form id="add-order-form">
  <h2 class="modal-title">Добавить продажу</h2>
  <div class="modal-inputs">
  <p>
  Клиент
<select id="clientField" data-validation="required">
  <option value="" disabled selected>Выберите клиента</option>
  <option class="new-client-option" value="-1">Добавить нового</option>';
    foreach ($more_data['clients'] as $key => $var) {
        $output .= '<option value="' . $var["id"] . '">' . $var["name"] . '</option>';
    }
    $output .= '
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
  <input id="sumVGField" min=0 data-validation="required length" data-validation-length="min1" placeholder="Кол-во виртуальной валюты" type="number" name="sum-vg">
  </p>
   <p>
   Не оплаченая часть
  <input id="debtClField" min=0 data-validation="required length" data-validation-length="min1" type="number" name="debt-sum" value = 0 step="0.01">
  </p>
  <p>
  Реферал
<select id="callmasterField">
  <option value="" selected>Выберите реферала(опц)</option>
  <option class="new-client-option" value="-1">Добавить нового</option>';
    foreach ($more_data['clients'] as $key => $var) {
        $output .= '<option value="' . $var["id"] . '">' . $var["name"] . '</option>';
    }
    $output .= '
  </select>
</p>
 <p>
  <textarea id="commentField" rows="3"  placeholder="Комментарий" name="description"></textarea>
  </p>
  <p>
  Продажа
  <input id="outField" min=0 data-validation="required length" data-validation-length="min1" placeholder="Продажа %" type="number" name="out">
  </p>
    <p>
    Способ получения
  <select id="obtainingField" data-validation="required">
  <option value="" disabled >Способ получения</option>;
  <option value="card" selected>На карту</option>;
  <option value="cash">Наличные</option>;
  </select>
  </p>
   </div><div id="owners-lists-container"></div>
   <div id="rollbacks-lists-container" class="modal-inputs" style="display: none">
<p>
   Откат
  <input id="rollback1Field" min="0" placeholder="Откат 1 %" type="number" name="rollback-1" step="0.01">
  </p>
  </div>
  <input class="modal-submit" type="submit" value="Оформить">
  </form>
</div>';
    //edit modal
    session_start();
    if (iCan(2)) {
        $output .= '
<div id="Order-edit-Modal" class="modal" action="" role="form">
<form id="edit-order-form">
  <h2 class="modal-title" id="edit-order-title">Редактировать данные продажи</h2>
  <div class="modal-inputs">
  <p>
  Клиент
<select id="editClientField" data-validation="required">
  <option value="" disabled selected>Выберите клиента</option>
  <option class="new-client-option" value="-1">Добавить нового</option>';
    foreach ($more_data['clients'] as $key => $var) {
        $output .= '<option value="' . $var["id"] . '">' . $var["name"] . '</option>';
    }
        $output .= '
  </select>
</p>
<p>
ВГ
<select id="editVgField" data-validation="required"><option value="" disabled selected>Выберите валюту</option>';
        foreach ($more_data['vgs'] as $key => $var) {
            $output .= '<option percent="' . $var["out_percent"] . '" value="' . $var['vg_id'] . '">' . $var['name'] . '</option>';
        }
        $output .= '
</select>
</p>
  <p>
  Сумма вг
  <input id="editSumVGField" min="0" data-validation="required length" data-validation-length="min1" placeholder="Кол-во виртуальной валюты" type="number" name="sum-vg">
  </p>
   <p>
   Не оплаченая часть
  <input id="editDebtClField" min="0" data-validation="required length" data-validation-length="min1" type="number" name="debt-sum" value = 0>
  </p>
  <p>
  Реферал
<select id="editCallmasterField">
  <option value="" selected>Выберите реферала(опц)</option>';
        foreach ($more_data['clients'] as $key => $var) {
            $output .= '<option value="' . $var["id"] . '">' . $var["name"] . '</option>';
        }
        $output .= '
  </select>
</p>
 <p>
  <textarea id="editCommentField" rows="3"  placeholder="Комментарий" name="description"></textarea>
  </p>
  <p>
  Продажа
  <input id="editOutField" min=0 data-validation="required length" data-validation-length="min1" placeholder="Продажа %" type="number" name="out" step=0.01>
  </p>
    <p>
    Способ получения
  <select id="editObtainingField" data-validation="required">
    <option value="" disabled >Способ получения</option>;
  <option value="card" selected>На карту</option>;
  <option value="cash">Наличные</option>;
  </select>
  </p>
  <p>
   Откат
  <input id="editRollback1Field" min="0" placeholder="Откат 1 %" type="number" name="rollback-1" step="0.01">
  </p>
  </div>
  <h2>Владельцы</h2>
  <div id="edit-owners-list-visible" class="orders-modal-owners-list"></div>
  <div id="open-invisible-owner-edit-list">Показать всех</div>
  <div id="edit-owners-list-invisible" class="orders-modal-owners-list"></div>
  <input class="modal-submit" type="submit" value="Сохранить">
  </form>
</div>';
    }
        $output .= '<a href="#Order-info-modal" rel="modal:open" style="display: none"></a>
<div id="Order-info-modal" class="modal">
<div id="info-order-form">
  <h2 class="modal-title">Иноформация про продажу</h2>
  <div class="text">
  </div>
  </div>
</div>';
        $output .='<a href="#Order-transaction-info-modal" rel="modal:open" style="display: none"></a>
<div id="Order-transaction-info-modal" class="modal">
 <h2>Ошибка транзакции!</h2>
 <h3 class="manually">Выполните вручную</h3>
 <div class="error-url-box">
 <span>Ссылка: </span><a target="_blank" id="error-url"></a>
</div>
</div>';
    $output .='<div id="noOwners-Modal" class="modal" action="">
<h2 class="no-owners-text">Для создания продажи требуется наличие валедльцев!</h2>
</div>';
    return $output;
}
