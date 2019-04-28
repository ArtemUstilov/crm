<?php
function debtModal($data)
{
    if ($data) {
        $i = 0;
        while ($new = $data->fetch_array()) {
            $copy_of_data[$i] = $new;
            $i++;
        }
    }
    if (!$copy_of_data) return '<div id="Debt-Modal" class="modal" action="">
<h2 class="no-payroll-text">Все долги погашены!</h2>
</div>';
    $output = '
<div id="Debt-Modal" class="modal" action="" role="form">
<form id="payback-debt-form">
  <h2 class="add-modal-title">Погасить долг</h2>
  <div class="add-modal-inputs">
  <p>
<select id="debtorField" data-validation="required">
  <option value="" selected disabled>Выберите должника</option>';
    foreach ($copy_of_data as $key => $var) {
        $output .= '<option sum="'.$var['debt'].'" value="' . $var['login'] . '">' . $var['client_name'] . ' (' . $var['login'] . ')</option>';
    }
    $output .= '
</select>
</p>
  <p>
  <input id="paybackField" data-validation="required length" data-validation-length="min1" placeholder="Выплата" type="number" name="in">
  </p>
  </div>
  <input class="add-modal-submit" type="submit" value="Выплатить">
  </form>
</div>';

    return $output;
}