<?php
function display_data($data, $add, $text, $more_data = NULL)
{
    session_start();
    $i = 0;
    while ($new = $data->fetch_array()) {
        $copy_of_data[$i] = $new;
        $i++;
    }
    $output = "<div class='table-menu'><h2>$text</h2>";
    if ($add == "User" || $add == "VG") {
        if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'sub-admin') {
            $output .= "<p><a id='add-btn' href=\"#Modal\" rel=\"modal:open\">Добавить</a></p>";
        }
    } else {
        if($add === 'rollback-main'){
            $output .= "<p><a id='add-btn' href='./referals.php#Modal' rel=\"modal:open\">Выплатить</a></p>";
        }else{
            $output .= "<p><a id='add-btn' href=\"#Modal\" rel=\"modal:open\">Добавить</a></p>";
        }
    }
    $output .= "</div>
<div class='table-wrapper' id='table-wrapper'>

<table id='table-container' class='table table-fixed'><thead id='table-head'>";
    if (!$copy_of_data || count($copy_of_data) === 0) {
        $output .= '<h2>Пусто</h2>';
    } else {
        foreach ($copy_of_data as $key => $var) {
            $index = 0;
            if ($key === 0) {
                $output .= '<tr>';
                foreach ($var as $col => $val) {
                    if (is_numeric($col)) continue;
                    $output .= "<th><div class='col-wrap'><p>" . $col . "</p><span></span></div><input id=$index-i>
</th>";
                    $index++;
                }
                $index = 0;
                $output .= '</tr></thead><div></div><tbody id="tbody">';
                $output .= '<tr>';
                foreach ($var as $col => $val) {
                    if (is_numeric($col)) continue;
                    $output .= '<td class=' . $index . '-f title="' . $val . '">' . $val . '</td>';
                    $index++;
                }
                $output .= '</tr>';
            } else {
                $index = 0;
                $output .= '<tr>';
                foreach ($var as $col => $val) {
                    if (is_numeric($col)) continue;
                    $output .= '<td class=' . $index . '-f title="' . $val . '">' . $val . '</td>';
                    $index++;
                }
                $output .= '</tr>';
            }
        }
    }

    $output .= '</tbody></table></div>';
    $output .= chooseAddModal($add, $copy_of_data, $more_data);
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

function chooseAddModal($name, $data, $more_data = NULL)
{
    switch ($name) {
        case "User":
            return userAddModal($data);
        case "Client":
            return clientAddModal($data);
            return;
        case "Order":
            return orderAddModal($data, $more_data);
        case "VG":
            return vgAddModal($data);
        case "Rollback":
            return rollbackModal($more_data);
    }
}

function userAddModal($data)
{
    $output = '
<div id="Modal" class="modal" action="" role="form">
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
  <select id="roleField" data-validation="required">
  <option value="" disabled selected>Выберите должность</option>
  <option value="manager">Менеджер</option>
</select>
</p>
<p>
  <input id="passField" name="pass_confirmation" type="password" data-validation="length required alphanumeric" data-validation-length="min6" placeholder="Пароль (только англ)">
  </p>
  <p>
  <input id="branchField" data-validation="required"  placeholder="Отделение" type="text" name="branch">
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


function clientAddModal($data)
{
    $output = '
<div id="Modal" class="modal" action="" role="form">
<form id="add-client-form">
  <h2 class="add-modal-title">Добавить клиента</h2>
  <div class="add-modal-inputs">
  <p>
  <input id="firstNameField" data-validation="required length" data-validation-length="min3" placeholder="Имя" type="text" name="name">
  </p>
  <p>
  <input id="lastNameField" data-validation="required length" data-validation-length="min3" placeholder="Фамилия" type="text" name="lastName">
  </p>
  <p>
  <input id="bynameField" data-validation="required length alphanumeric" data-validation-length="min4" placeholder="Логин (кличка, только англ)" type="text" name="byname">
  </p>
   <p>
  <input id="phoneField" data-validation="required length" data-validation-length="min6" placeholder="Телефон" type="text" name="phone">
  </p>
  <p>
  <input id="emailField"   placeholder="Email" type="email" name="email">
  </p>
  <p>
  <select id="callmasterField" data-validation="required">
  <option value="" selected>Выберите пригласившего</option>';
    foreach ($data as $key => $var) {
        $output .= '<option value="' . $var['Полное имя'] . '">' . $var['Полное имя'] . ' (' . $var['Имя'] . ')</option>';
    }
    $output .= '
</select>
</p>
  <p>
  <textarea id="descriptionField" rows="5" data-validation="required"  placeholder="Описание" type="text" name="description"></textarea>
  </p>
 
  </div>
  <input class="add-modal-submit" type="submit" value="Добавить">
  </form>
</div>';

    return $output;
}

function vgAddModal($data)
{
    $output = '
<div id="Modal" class="modal" action="" role="form">
<form id="add-vg-form">
  <h2 class="add-modal-title">Добавить валюту</h2>
  <div class="add-modal-inputs">
  <p>
  <input id="nameField" data-validation="required length" data-validation-length="min1" placeholder="Название" type="text" name="name">
  </p>
  <p>
  <input id="inField" data-validation="required length" data-validation-length="min1" placeholder="покупка %" type="number" name="in">
  </p>
  <p>
  <input id="outField" data-validation="required length" data-validation-length="min1" placeholder="продажа %" type="number" name="out">
  </p>
   <p>
  <input id="urlField" data-validation="required length" data-validation-length="min4" placeholder="url" type="url" name="url">
  </p>
  </div>
  <input class="add-modal-submit" type="submit" value="Добавить">
  </form>
</div>';

    return $output;
}

function orderAddModal($data, $more_data)
{
    session_start();
    $id = $_SESSION['id'];
    $output = '
<div id="Modal" class="modal" action="" role="form">
<form id="add-vg-form">
  <h2 class="add-modal-title">Добавить продажу</h2>
  <div class="add-modal-inputs">
<select id="clientField" data-validation="required">
  <option value="" disabled selected>Выберите клиента</option>\';
    foreach ($data as $key => $var) {
        $output .= \'<option value="\' . $var[\'Полное имя\'] . \'">\' . $var[\'Полное имя\'] . \' (\' . $var[\'Имя\'] . \')</option>\';
    }
    $output .= \'
</select>
  <p>
  <input id="inField" data-validation="required length" data-validation-length="min1" placeholder="покупка %" type="number" name="in">
  </p>
  <p>
  <input id="outField" data-validation="required length" data-validation-length="min1" placeholder="продажа %" type="number" name="out">
  </p>
   <p>
  <input id="urlField" data-validation="required length" data-validation-length="min4" placeholder="url" type="url" name="url">
  </p>
  </div>
  <input class="add-modal-submit" type="submit" value="Создать">
  </form>
</div>';

    return $output;
}

function rollbackModal($data)
{
    $i = 0;
    while ($new = $data->fetch_array()) {
        $copy_of_data[$i] = $new;
        $i++;
    }
    if(!$copy_of_data) return '<div id="Modal" class="modal" action="">
<h2 class="no-payroll-text">Все откаты выплачены!</h2>
</div>';
    $output = '
<div id="Modal" class="modal" action="" role="form">
<form id="pay-rollback-form">
  <h2 class="add-modal-title">Добавить продажу</h2>
  <div class="add-modal-inputs">
  <p>
<select id="clientField" data-validation="required">
  <option value="" selected disabled>Выберите клиента</option>';
    foreach ($copy_of_data as $key => $var) {
        $output .= '<option value="' . $var['login'] . '">' . $var['client_name'] . ' (' . $var['login'] . ')</option>';
    }
    $output .= '
</select>
</p>
  <p>
  <input id="payField" data-validation="required length" data-validation-length="min1" placeholder="Выплата" type="number" name="in">
  </p>
  </div>
  <input class="add-modal-submit" type="submit" value="Выплатить">
  </form>
</div>';

    return $output;
}