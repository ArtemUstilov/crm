<?php
function headAddModal($data)
{
    if ($data) {
        $i = 0;
        while ($new = $data['branches']->fetch_array()) {
            $branches[$i] = $new;
            $i++;
        }
        $i = 0;
        while ($new = $data['clients']->fetch_array()) {
            $clients[$i] = $new;
            $i++;
        }
    }
    if (!$branches) return '<div id="Head-Modal" class="modal" action="">
<h2 class="no-payroll-text">Сначала добавьте предприятие!</h2>
</div>';

    $output = '
<div id="Head-Modal" class="modal" action="" role="form">
<form id="add-head-form">
  <h2 class="add-modal-title">Добавить владельца</h2>
  <div class="add-modal-inputs">
  <p>
  <select id="nameField" data-validation="required">
  <option value="" disabled selected>Выберите человека</option>';
    if($clients) foreach ($clients as $key => $var) {
        $output .= '<option value="' . $var['first_name']." ". $var['last_name']  . '">' . $var['first_name']." ". $var['last_name'] . '</option>';
    }
    $output .= '
</select>
  </p>
  <p>
  <select id="branchField" data-validation="required">
  <option value="" disabled selected>Выберите предприятие</option>';
    if($branches) foreach ($branches as $key => $var) {
        $output .= '<option value="' . $var['id'] . '">' . $var['branch_name'] . '</option>';
    }
    $output .= '
</select>
</p>
  </div>
  <input class="add-modal-submit" type="submit" value="Добавить">
  </form>
</div>';
    return $output;
}
