<?php
function display_data($data, $add)
{

    $output = "<div id='wrapper'><div class='table-menu'><p><a id='add-btn' href=\"#{$add}Modal\" rel=\"modal:open\">Добавить</a></p></div>
<div class='table-wrapper'>
<table id='table-container'><thead>";
    foreach ($data as $key => $var) {
        $currentCol = '';
        $index = 0;
        if ($key === 0) {
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= "<th><div class='col-wrap'><p>" . $col . "</p><span></span></div><input id=$index-i>
</th>";
                $currentCol = $val;
                $index++;
            }
            $index = 0;
            $output .= '</tr></thead><tbody id="tbody">';
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= '<td class=' . $index . '-f title="' . $val . '">' . $val . '</td>';
                $index++;
            }
            $output .= '</tr>';
        } else {
            $index = 0;
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= '<td class=' . $index . '-f title="' . $val . '">' . $val . '</td>';
                $index++;
            }
            $output .= '</tr>';
        }
    }
    $output .= '</tbody></table></div>

</div>';
    $output .= chooseAddModal($add, $data);
    return $output;
}

function clean($value = "")
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

function isAuthorized()
{
    session_start();
    if (isset($_SESSION['id']) && isset($_SESSION['login']) && isset($_SESSION['password'])) return true;
    return false;
}

function chooseAddModal($name, $data)
{
    switch ($name) {
        case "User":
            return userAddModal($data);
        case "Client":
            return;
        case "Order":
            return;
    }
}

function userAddModal($data)
{
    $output = '
<div id="UserModal" class="modal" action="" role="form">
<form id="add-user-form">
  <h2 class="add-modal-title">Добавить пользователя</h2>
  <div class="add-modal-inputs">
  <p>
  <input id="firstNameField" data-validation="required length alphanumeric" data-validation-length="min3" placeholder="Имя" type="text" name="name">
  </p>
  <p>
  <input id="lastNameField" data-validation="required length alphanumeric" data-validation-length="min3" placeholder="Фамилия" type="text" name="lastName">
  </p>
  <p>
  <input id="loginField" data-validation="required length alphanumeric" data-validation-length="min5" placeholder="Логин" type="text" name="login">
  </p>
  <p>
  <select id="roleField" data-validation="required">
  <option value="" disabled selected>Выберите должность</option>
  <option value="manager">Менеджер</option>
</select>
</p>
<p>
  <input id="passField" name="pass_confirmation" type="password" data-validation="length required" data-validation-length="min8" placeholder="Пароль">
  </p>
  <p>
  <input id="branchField" data-validation="required"  placeholder="Отделение" type="text" name="branch">
  </p>
  <p>
  <input id="passRepeatField" name="pass" type="password" data-validation-error-msg="Пароли не совпадают" placeholder="Повторите пароль" data-validation-length="min8" data-validation="length required confirmation">
  </p>
  </div>
  <input rel="modal:close"  class="add-modal-submit" type="submit" value="Submit">
  </form>
</div>';
    return $output;
}
