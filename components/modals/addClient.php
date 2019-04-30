<?php
function clientAddModal($data)
{
    $output = '
<div id="Client-Modal" class="modal" action="" role="form">
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
  <textarea id="descriptionField" rows="3" data-validation="required"  placeholder="Описание" type="text" name="description"></textarea>
  </p>
 
  </div>
  <input class="add-modal-submit" type="submit" value="Добавить">
  </form>
</div>';
    session_start();
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moder')
    $output .= '
<div id="Client-edit-Modal" class="modal" action="" role="form">
<form id="edit-client-form">
  <h2 class="add-modal-title" id="edit-client-title">Изменить данные клиента</h2>
  <div class="add-modal-inputs">
  <p>
  Имя
  <input id="editFirstNameField" data-validation="required length" data-validation-length="min3" placeholder="Имя" type="text" name="name">
  </p>
  <p>
  Фамилия
  <input id="editLastNameField" data-validation="required length" data-validation-length="min3" placeholder="Фамилия" type="text" name="lastName">
  </p>
  <p>
  Логин(клика)
  <input id="editBynameField" data-validation="required length alphanumeric" data-validation-length="min4" placeholder="Логин (кличка, только англ)" type="text" name="byname">
  </p>
   <p>
   Номер телефона
  <input id="editPhoneField" data-validation="required length" data-validation-length="min6" placeholder="Телефон" type="text" name="phone">
  </p>
  <p>
  Email
  <input id="editEmailField"   placeholder="Email" type="email" name="email">
  </p>

  <p>
  Описание
  <textarea id="editDescriptionField" rows="3" data-validation="required"  placeholder="Описание" type="text" name="description"></textarea>
  </p>
 
  </div>
  <input class="add-modal-submit" type="submit" value="Сохранить">
  </form>
</div>';

    return $output;
}
