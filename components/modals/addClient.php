<?php
function clientAddModal($data)
{
    $output = '
<div id="Client-Modal" class="modal" action="" role="form">
<form id="add-client-form">
  <h2 class="modal-title">Добавить клиента</h2>
  <div class="modal-inputs">
  <p>
  Имя
  <input id="firstNameField" data-validation="required length" data-validation-length="min3" placeholder="Имя" type="text" name="name">
  </p>
  <p>
  Фамилия
  <input id="lastNameField" data-validation="required length" data-validation-length="min3" placeholder="Фамилия" type="text" name="lastName">
  </p>
  <p>
    Логин(идентификатор в VG)
  <input id="bynameField" data-validation="required length alphanumeric" data-validation-length="min4" placeholder="Логин" type="text" name="byname">
  </p>
   <p>
   Номер телефона
  <input id="phoneField" placeholder="Телефон" type="text" name="phone">
  </p>
  <p>
   Телеграм
  <input id="tgField" placeholder="Телеграм" type="text" name="tg">
  </p>
  <p>
  Email
  <input id="emailField"   placeholder="Email" type="email" name="email">
  </p>

  <p>
  <textarea id="descriptionField" rows="3" data-validation="required"  placeholder="Описание" type="text" name="description"></textarea>
  </p>
 
  </div>
  <input class="modal-submit" type="submit" value="Добавить">
  </form>
</div>';
    session_start();
    if (iCan(2))
    $output .= '
<div id="Client-edit-Modal" class="modal" action="" role="form">
<form id="edit-client-form">
  <h2 class="modal-title" id="edit-client-title">Изменить данные клиента</h2>
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
  Логин(идентификатор в VG)
  <input id="editBynameField" data-validation="required length alphanumeric" data-validation-length="min4" placeholder="Логин" type="text" name="byname">
  </p>
   <p>
   Номер телефона
  <input id="editPhoneField" placeholder="Телефон" type="text" name="phone">
  </p>
  <p>
   Телеграм
  <input id="editTgField" placeholder="Телеграм" type="text" name="tg">
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
  <input class="modal-submit" type="submit" value="Сохранить">
  </form>
</div>';
    $output .= '<a href="#Client-info-modal" rel="modal:open" style="display: none"></a>
<div id="Client-info-modal" class="modal" style="width: auto; text-align:center">
<div id="info-client-form">
  <h2 class="modal-title">Иноформация про клиента</h2>
  <div class="text">
  </div>
  </div>
</div>';
    return $output;
}
