<?php
function rollbackModal($data)
{
    if ($data) {
        $i = 0;
        while ($new = $data->fetch_array()) {
            $copy_of_data[$i] = $new;
            $i++;
        }
    }
    include_once '/dev/ChromePhp.php';
    ChromePhp::log($copy_of_data);
    if (!$copy_of_data) return '<div id="Rollback-Modal" class="modal" action="">
<h2 class="no-payroll-text">Все откаты выплачены!</h2>
</div>';
    $output = '
<div id="Rollback-Modal" class="modal" action="" role="form">
<form id="pay-rollback-form">
  <h2 class="modal-title">Выплатить откат</h2>
  <div class="modal-inputs">
  <p>
<select id="clientField" data-validation="required">
  <option value="" selected disabled>Выберите клиента</option>';
    foreach ($copy_of_data as $key => $var) {
        $output .= '<option sum="'.$var['rollback_sum'].'" value="' . $var['login'] . '">' . $var['client_name'] . ' (' . $var['login'] . ')</option>';
    }
    $output .= '
</select>
</p>
  <p>
  <input id="payField" data-validation="required length" data-validation-length="min1" placeholder="Выплата" type="number" name="in">
  </p>
  </div>
  <input class="modal-submit" type="submit" value="Выплатить">
  </form>
</div>';

    return $output;
}