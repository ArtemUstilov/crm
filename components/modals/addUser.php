<?php
function userAddModal($data, $more_data)
{
    $output = '
<div id="User-Modal" class="modal" action="" role="form">
<form id="add-user-form">
  <h2 class="modal-title">Добавить пользователя</h2>
  <div class="modal-inputs">
  <p>
  <input id="firstNameField" data-validation="required length" data-validation-length="min3" placeholder="Имя" type="text" name="name">
  </p>
  <p>
  <input id="lastNameField" data-validation="required length" data-validation-length="min3" placeholder="Фамилия" type="text" name="lastName">
  </p>
  <p>
  <input id="loginField" autocomplete="username" data-validation="required length alphanumeric" data-validation-length="min5" placeholder="Логин (только англ)" type="text" name="login">
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

  <input id="passField" autocomplete="new-password"  name="pass_confirmation" type="password" data-validation="length required alphanumeric" data-validation-length="min3" placeholder="Пароль (только англ)">
  </p>
  <p>
  <select id="roleField" data-validation="required">
  <option value="" disabled selected>Выберите должность</option>
  <option value="agent">Агент</option>
   <option value="admin">Администратор</option>
     '.(iCan(3) ? '<option value="moder">Модератор</option>' : '').'
    </select>
  </p>
  <p>
  <input id="passRepeatField" autocomplete="new-password" name="pass" type="password"  placeholder="Повторите пароль" data-validation-length="min3" data-validation="length required confirmation">
  </p>
  </div>
  <input class="modal-submit" type="submit" value="Добавить">
  </form>
</div>';
    session_start();
    if (iCan(2)) {
        $output .= '
<div id="User-edit-Modal" class="modal" action="" role="form">
<form id="edit-user-form">
  <h2 class="modal-title" id="edit-user-title">Изменить данные пользователя</h2>
  <div class="modal-inputs">
  <p>
  Имя
  <input id="editFirstNameField" data-validation="required length" data-validation-length="min3" placeholder="Имя" type="text" name="name">
  </p>
  <p>
  Фамилия
  <input id="editLastNameField" data-validation="required length" data-validation-length="min3" placeholder="Фамилия" type="text" name="lastName">
  </p>
  <p>
  Логин
  <input id="editLoginField" autocomplete="username" data-validation="required length alphanumeric" data-validation-length="min5" placeholder="Логин (только англ)" type="text" name="login">
  </p>
  <p>
  Деньги
  <input id="editMoneyField"    placeholder="Логин (только англ)" type="number" name="money">
  </p>
  <p>
  Отдел
  <select id="editBranchField" data-validation="required">
  <option value="" disabled selected>Выберите отдел</option>';
        foreach ($more_data as $key => $var) {
            $output .= '<option value="' . $var["branch_id"] . '">' . $var["branch_name"] . '</option>';
        }
        $output .= '
</select>
</p>';
        session_start();
            $output .= '
  <p>
  Должность
  <select id="editRoleField" data-validation="required">
  <option value="" disabled selected>Выберите должность</option>
  <option value="agent">Агент</option>
   <option value="admin">Администратор</option>
    '.(iCan(3) ? '<option value="moder">Модератор</option>' : '').'
    </select>
  </p>';
        $output .= '
<p>
Пароль
  <input id="editPassField" autocomplete="new-password" name="pass_confirmation" type="password" data-validation="length required alphanumeric" data-validation-length="min3" placeholder="Пароль (только англ)">
  </p>
  <p>
    Повторите пароль
    <input 
        id="editPassRepeatField" 
        autocomplete="new-password" 
        name="pass" type="password"  
        placeholder="Повторите пароль" 
        data-validation="confirmation">
  </p>
  </div>
  <input class="modal-submit" type="submit" value="Сохранить">
  </form>
</div>';
    }
    return $output;
}
