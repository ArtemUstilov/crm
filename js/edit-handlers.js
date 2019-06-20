//Order

const vg = $('#Order-edit-Modal #editVgField');
vg.change(function (e) {
    let vg_id = vg.val();
    if (vg_id) {
        const optionSelected = $("option:selected", '#Order-edit-Modal #editVgField');
        const perc = optionSelected.attr('percent');
        $('#editOutField').val(perc);
    }
});

$.validate({
    form: '#edit-order-form',
    modules: '',
    lang: 'ru',
    onSuccess: function () {
        editOrder();
        return false;
    }
});

function editOrder() {
    let order_id = $('#edit-order-form #edit-order-title').attr('order-id');
    let sum_vg = $("#edit-order-form #editSumVGField").val();
    let debt = $("#edit-order-form #editDebtClField").val();
    let referral = $("#edit-order-form #editLastNameField").val();
    let rollback_1 = $("#edit-order-form #editRollback1Field").val();
    let out = $("#edit-order-form #editOutField").val();
    let descr = $("#edit-order-form #editCommentField").val();
    let vg_id = $("#edit-order-form #editVgField").val();
    let callmaster = $('#edit-order-form #editCallmasterField').val();
    let obtain = $('#edit-order-form #editObtainingField').val();
    let client_id = $("#edit-order-form #editClientField").val();
    let fiat = $('#edit-order-form #editFiatField').val();
    let sharesEls = $('#edit-order-form .edit-owner-percent-input');
    const allShares = [];
    sharesEls.each(function () {
        allShares.push({value: $(this).val(), owner_id: $(this).attr('owner-id')});
    });
    const shares = allShares.filter((el) => el.value > 0);
    const $this = $("#edit-order-form .modal-submit");
    $this.prop("disabled", true);
    $.ajax({
        url: "../components/edit-modal-response/editOrder.php",
        type: "POST",
        dataType: "JSON",
        data: {
            order_id,
            client_id,
            sum_vg,
            debt,
            referral,
            rollback_1,
            out,
            vg_id,
            shares,
            callmaster,
            obtain,
            descr,
            fiat,
        },
        cache: false,
        success: function (res) {
            if (!res.sumChanged) {
                createAlertTable(res.status, "Заказ");
                return;
            }

            createAlertTable(res.status, "Заказ");
            $('#Order-sum-changed-modal .old-sum').text(res.oldSum);
            $('#Order-sum-changed-modal .new-sum').text(res.newSum);
            $('#Order-sum-changed-modal').modal();
        },
        error: function () {
            createAlertTable("connectionError", "Заказ");
        },
        complete: function () {
            setTimeout(function () {
                $this.prop("disabled", false);
            }, 300);
        }
    });
}

$('#Order-sum-changed-modal').on($.modal.BEFORE_CLOSE, function (event, modal) {
    location.reload();
});

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
    let telegram = $("#edit-user-form #telegram").val();

    const $this = $("#edit-user-form .modal-submit");
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
            user_id: id,
            telegram,
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
    let telegram = $("#edit-client-form #editTgField").val();
    let first_name = $("#edit-client-form #editFirstNameField").val();
    let last_name = $("#edit-client-form #editLastNameField").val();
    let description = $("#edit-client-form #editDescriptionField").val();
    let email = $("#edit-client-form #editEmailField").val();
    let rollback = $("#edit-client-form #editRollbackField").val();
    let debt = $("#edit-client-form #editDebtField").val();
    let id = $("#edit-client-form #edit-client-title").attr('client-id');
    const $this = $("#edit-client-form .modal-submit");
    let password = $("#edit-client-form #editPasswordField").val();
    let payment_system = $("#edit-client-form #payment_system").is(':checked');
    let pay_in_debt = $("#edit-client-form #pay_in_debt").is(':checked');
    let pay_page = $("#edit-client-form #pay_page").is(':checked');
    let max_debt = $("#edit-client-form #editMaxDebtField").val();
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
            rollback,
            debt,
            phone,
            telegram,
            client_id: id,
            password, pay_in_debt,
            pay_page,
            payment_system,
            max_debt,
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

//VG
$.validate({
    form: '#edit-vg-form',
    modules: '',
    lang: 'ru',
    onSuccess: function () {
        editVG();
        return false;
    }
});

function editVG() {
    let name = $("#edit-vg-form #editNameField").val();
    let in_percent = $("#edit-vg-form #editInField").val();
    let out_percent = $("#edit-vg-form #editOutField").val();
    let url = $("#edit-vg-form #editUrlField").val();
    let key = $("#edit-vg-form #editKeyField").val();
    let id = $("#edit-vg-form #edit-vg-title").attr('vg-id');
    const $this = $("#edit-client-form .modal-submit");
    $this.prop("disabled", true);
    $.ajax({
        url: "../components/edit-modal-response/editVG.php",
        type: "POST",
        data: {
            name,
            out_percent,
            in_percent,
            url,
            key,
            vg_id: id,
        },
        cache: false,
        success: function (res) {
            createAlertTable(res, "VG");
        },
        error: function () {
            createAlertTable("connectionError", "VG");
        },
        complete: function () {
            setTimeout(function () {
                $this.prop("disabled", false);
            }, 300);
        }
    });
}


//Fiat
$.validate({
    form: '#edit-fiat-form',
    modules: '',
    lang: 'ru',
    onSuccess: function () {
        editFiat();
        return false;
    }
});

function editFiat() {
    let name = $("#edit-fiat-form #editNameFiatField").val();
    let full_name = $("#edit-fiat-form #editFullNameFiatField").val();
    let code = $("#edit-fiat-form #editCodeField").val();
    let fiat = $("#edit-fiat-form #edit-fiat-title").attr('fiat-id');
    const $this = $("#edit-fiat-form .modal-submit");
    $this.prop("disabled", true);
    $.ajax({
        url: "../components/edit-modal-response/editFiat.php",
        type: "POST",
        data: {
            name,
            full_name,
            code,
            fiat,
        },
        cache: false,
        success: function (res) {
            createAlertTable(res, "Валюта");
        },
        error: function () {
            createAlertTable("connectionError", "Fiat");
        },
        complete: function () {
            setTimeout(function () {
                $this.prop("disabled", false);
            }, 300);
        }
    });
}


//Branch
$.validate({
    form: '#edit-branch-form',
    modules: '',
    lang: 'ru',
    onSuccess: function () {
        editBranch();
        return false;
    }
});

function editBranch() {
    let name = $("#edit-branch-form #editNameField").val();
    let money = $("#edit-branch-form #editMoneyField").val();
    let id = $("#edit-branch-form #edit-branch-title").attr('branch-id');
    const $this = $("#edit-client-form .modal-submit");
    $this.prop("disabled", true);
    $.ajax({
        url: "../components/edit-modal-response/editBranch.php",
        type: "POST",
        data: {
            name,
            branch_id: id,
            money,
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
            $.modal.close();
            setTimeout(function () {
                location.reload();
            }, 1500);
            break;
        case "edit-success":
            $('.custom-alert .alert-text-box').text(`Изменения сохранены`);
            $('.custom-alert').addClass('bg-green');
            $.modal.close();
            setTimeout(function () {
                location.reload();
            }, 2500);
            break;
        case "success-replenish":
            $('.custom-alert .alert-text-box').text(`Деньги успешно зачислены`);
            $('.custom-alert').addClass('bg-green');
            $.modal.close();
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