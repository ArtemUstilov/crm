<?php
function projectAddModal()
{
    return '
<div id="Project-Modal" class="modal" action="" role="form">
<form id="add-project-form">

  <h2 class="modal-title">Добавить проект</h2>
  <div class="modal-inputs">
  <p>
  <input id="project-name" data-validation="required"  placeholder="Название" type="text" name="name" >
  </p>
  </div>
  <input class="modal-submit" type="submit" value="Добавить">
  </form>
</div>' . projectEditModal();
}

function projectEditModal()
{
    return '
<div id="Project-edit-Modal" class="modal" action="" role="form">
<form id="edit-project-form">
  <h2 class="modal-title">Редактировать данные проекта</h2>
  <div class="modal-inputs">
  <p>
  <input id="project-edit-name" data-validation="required"  placeholder="Название" type="text" name="name" >
  </p>
  </div>
  <input class="modal-submit" type="submit" value="Сохранить">
  </form>
</div>';
}