<?php
function headAddModal($data)
{
    if ($data) {
        $i = 0;
        while ($new = $data->fetch_array()) {
            $copy_of_data[$i] = $new;
            $i++;
        }
    }
    if (!$copy_of_data) return '<div id="Head-Modal" class="modal" action="">
<h2 class="no-payroll-text">Сначала добавьте предприятие!</h2>
</div>';

    $output = '
<div id="Head-Modal" class="modal" action="" role="form">
<form id="add-head-form">
  <h2 class="add-modal-title">Добавить владельца</h2>
  <div class="add-modal-inputs">
  <p>
  <input id="firstNameField" data-validation="required length" data-validation-length="min3" placeholder="Имя" type="text" name="name">
  </p>
  <p>
  <input id="lastNameField" data-validation="required length" data-validation-length="min3" placeholder="Фамилия" type="text" name="lastName">
  </p>
  <p>
  <select id="branchField" data-validation="required">
  <option value="" disabled selected>Выберите предприятие</option>';
    foreach ($copy_of_data as $key => $var) {
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
