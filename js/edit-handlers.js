
//User
$.validate({
    form: '#edit-user-form',
    modules: '',
    lang: 'ru',
    onSuccess: function () {
        editUser();
        return false;
    }
});

function editUser() {
    let password = $("#edit-user-form #editPassField").val();
    let login = $("#edit-user-form #editLoginField").val();
    let first_name = $("#edit-user-form #editFirstNameField").val();
    let last_name = $("#edit-user-form #editLastNameField").val();
    let branch = $("#edit-user-form #editBranchField").val();
    let money = $("#edit-user-form #editMoneyField").val();
    let role = $("#edit-user-form #editRoleField").val();
    let id = $("#edit-user-form #edit-user-title").attr('user-id');
    const $this = $("#edit-user-form .modal-submit");
    console.log('eee');
    $this.prop("disabled", true);
    $.ajax({
        url: "../components/edit-modal-response/editUser.php",
        type: "POST",
        data: {
            password,
            login,
            first_name,
            last_name,
            branch,
            money,
            role,
            user_id : id,
        },
        cache: false,
        success: function (res) {
            createAlertTable(res, "Пользователь");
        },
        error: function () {
            createAlertTable("connectionError", "Пользователь");
        },
        complete: function () {
            setTimeout(function () {
                $this.prop("disabled", false);
            }, 300);
        }
    });
}
//Client
$.validate({
    form: '#edit-client-form',
    modules: '',
    lang: 'ru',
    onSuccess: function () {
        editClient();
        return false;
    }
});

function editClient() {
    let phone = $("#edit-client-form #editPhoneField").val();
    let byname = $("#edit-client-form #editBynameField").val();
    let first_name = $("#edit-client-form #editFirstNameField").val();
    let last_name = $("#edit-client-form #editLastNameField").val();
    let description = $("#edit-client-form #editDescriptionField").val();
    let email = $("#edit-client-form #editEmailField").val();
    let id = $("#edit-client-form #edit-user-title").attr('client-id');
    const $this = $("#edit-client-form .modal-submit");
    $this.prop("disabled", true);
    $.ajax({
        url: "../components/edit-modal-response/editClient.php",
        type: "POST",
        data: {
            description,
            email,
            first_name,
            last_name,
            byname,
            phone,
            client_id : id,
        },
        cache: false,
        success: function (res) {
            createAlertTable(res, "Пользователь");
        },
        error: function () {
            createAlertTable("connectionError", "Пользователь");
        },
        complete: function () {
            setTimeout(function () {
                $this.prop("disabled", false);
            }, 300);
        }
    });
}
function createAlertTable(alertType, text) {
    if ($('.custom-alert').hasClass('custom-alert--active'))
        $('.custom-alert').removeClass('custom-alert--active');
    if ($('.custom-alert').hasClass('bg-green')) $('.custom-alert').removeClass('bg-green');
    switch (alertType) {
        case "exists":
            $('.custom-alert .alert-text-box').text(`${text} с таким логином уже существует`);
            break;
        case "success":
            $('.custom-alert .alert-text-box').text(`${text} успешно добавлен`);
            $('.custom-alert').addClass('bg-green');
            let linkEvent = document.createEvent('MouseEvents');
            linkEvent.initEvent('click', true, true);
            $('.close-modal')[0].dispatchEvent(linkEvent);
            break;
        case "failed":
            $('.custom-alert .alert-text-box').text('Что-то пошло не так. Попробуйте еще раз');
            break;
        case "denied":
            $('.custom-alert .alert-text-box').text('Недостаточно прав доступа');
            break;
        case "empty":
            $('.custom-alert .alert-text-box').text('Введены не все данные');
            break;
        case "connectionError":
            $('.custom-alert .alert-text-box').text('Ошибка сети. Перезагрузите страницу и попробуйте еще раз');
            break;
    }
    setTimeout(function () {
        $('.custom-alert').addClass('custom-alert--active');
    }, 300);

}