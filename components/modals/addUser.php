<?php
function userAddModal($data, $more_data)
{
    $output = '
<div id="User-Modal" class="modal" action="" role="form">
<form id="add-user-form">
  <h2 class="add-modal-title">Добавить пользователя</h2>
  <div class="add-modal-inputs">
  <p>
  <input id="firstNameField" data-validation="required length" data-validation-length="min3" placeholder="Имя" type="text" name="name">
  </p>
  <p>
  <input id="lastNameField" data-validation="required length" data-validation-length="min3" placeholder="Фамилия" type="text" name="lastName">
  </p>
  <p>
  <input id="loginField" data-validation="required length alphanumeric" data-validation-length="min5" placeholder="Логин (только англ)" type="text" name="login">
  </p>
  <p>
  <select id="branchField" data-validation="required">
  <option value="" disabled selected>Выберите отделение</option>';
    foreach ($more_data as $key => $var) {
        $output .= '<option value="' . $var["branch_id"] . '">' . $var["branch_name"] . '</option>';
    }
    $output .= '
</select>
</p>
<p>

  <input id="passField" name="pass_confirmation" type="password" data-validation="length required alphanumeric" data-validation-length="min6" placeholder="Пароль (только англ)">
  </p>
  <p>
  <select id="roleField" data-validation="required">
  <option value="" disabled selected>Выберите должность</option>
  <option value="manager">Менеджер</option>
   <option value="moder">Модератор</option>
    <option value="admin">Администратор</option>
    </select>
  </p>
  <p>
  <input id="passRepeatField" name="pass" type="password"  placeholder="Повторите пароль" data-validation-length="min8" data-validation="length required confirmation">
  </p>
  </div>
  <input class="add-modal-submit" type="submit" value="Добавить">
  </form>
</div>';
    return $output;
}
