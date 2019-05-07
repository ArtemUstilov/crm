checkIfActive();
$('tr').on('click', (e) => {
    const target = $(e.target);
    const mainParent = target.parent().parent();
    switch (target.attr('modal')) {
        case "#Debt-Modal":
            $('[href*="#Debt-Modal"]').first()[0].click();
            const debtorList = $('#debtorField');
            debtorList.val(target.parent().parent().attr('defaultval'));
            const debtorSelected = $("option:selected", debtorList);
            const debtSum = debtorSelected.attr('sum');
            const input = $('#paybackField');
            input.val(debtSum);
            input.attr('max', debtSum);
            input.attr('min', 0);
            break;
        case "#Rollback-Modal":
            $('[href*="#Rollback-Modal"]').first()[0].click();
            const referalList = $('#clientField');
            referalList.val(target.parent().parent().attr('defaultval'));
            const referalSelected = $("option:selected", referalList);
            const rollbackSum = referalSelected.attr('sum');
            const input2 = $('#payField');
            input2.val(rollbackSum);
            input2.attr('max', rollbackSum);
            input2.attr('min', 0);
            break;
        case "Head-edit":
            fillOwnerEditForm();
            break;
        case "User-edit":
            fillUserEditForm(mainParent);
            break;
        case "Branch-edit":
            fillBranchEditForm(mainParent);
            break;
        case "Client-edit":
            fillClientEditForm(mainParent);
            break;
        case "VG-edit":
            fillVGEditForm(mainParent);
            break;
        case "Order-edit":
            fillOrderEditForm(mainParent);
            break;
        case "info":
            fillOrderAdditionalInfo(mainParent);
            break;
        default:
            break;
    }

});

function fillOrderAdditionalInfo(target) {
    $(".spinner").show();
    let order_id = target.attr('itemid');
    $.ajax({
        url: "../components/selectors/OrderInfo.php",
        type: "POST",
        dataType: 'JSON',
        data: {
            order_id,
        },
        cache: false,
        success: function (res) {
            $('#info-order-form .modal-title').text(`Информация о продаже №${order_id}`).attr('order-id', res['id']);
            let owners = '<h4>Владельцы</h4>' + res.map(line => `<br/><p>${line["name"]} - ${line["sum"]} грн (${line["share_percent"]}%)</p>`).join('');
            const callmaster = `<br/><h4>Реферал:</h4><br/><p>${res[0]["callmaster"]} - ${res[0]["rollback_sum"]} грн (${res[0]["rollback_1"]}%)</p>`;
            if (res[0]["callmaster"])
                owners += callmaster;
            $('#info-order-form .text').html(owners);
        },
        error: function () {
            $('#info-order-form .modal-title').text(`Нет информации про продажу № ${order_id}`);
        },
        complete: function () {
            $(".spinner").fadeOut('fast');
            $("#Order-info-modal").modal();

        }
    });
}

function fillOrderEditForm(target) {
    $(".spinner").show();
    let order_id = target.attr('itemid');
    $.ajax({
        url: "../components/selectors/Order.php",
        type: "POST",
        dataType: 'JSON',
        data: {
            order_id,
        },
        cache: false,
        success: function (res) {
            $('#edit-order-form #edit-order-title').text(`Редактировать продажу №${res['order_id']}`).attr('order-id', res['order_id']);
            $('#edit-order-form #editClientField').val(res['client_id']);
            $('#edit-order-form #editClientField option').each(function () {
                if (!res['clients'].find(t => t.client_id === this.value || this.value == -1)) {
                    $(this).hide();
                }
            });
            $('#edit-order-form #editVgField').val(res['vg_id']);
            $('#edit-order-form #editSumVGField').val(res['sum_vg']);
            if (res['callmaster'])
                $('#edit-order-form #editCallmasterField').val(res['callmaster']);
            $('#edit-order-form #editDebtClField').val(res['debt']);
            $('#edit-order-form #editOutField').val(res['out']);
            $("#edit-order-form #editCommentField").val(res['comment']);
            $('#edit-order-form #editRollback1Field').val(res['rollback_1']);
            $('#edit-order-form #editObtainingField').val(res['method']);
            if (res['shares'])
                res['shares'].forEach((el => {
                    $('#edit-owners-list-visible').append(
                        "<p class='edit-owner-percent-input-box'>" +
                        `${el['owner_name']}` +
                        "<input class='edit-owner-percent-input' type='number' " +
                        `owner-id=${el["owner_id"]} placeholder='Процент прибыли' ` +
                        `value=${el['percent']}> ` +
                        "</p>");
                }))
            if (res['other_owners']) {
                $('#open-invisible-owner-edit-list').removeClass('display-none');
                res['other_owners'].forEach((el => {
                    $('#edit-owners-list-invisible').append(
                        "<p class='edit-owner-percent-input-box'>" +
                        `${el['owner_name']}` +
                        "<input class='edit-owner-percent-input' type='number' " +
                        `owner-id=${el["owner_id"]} placeholder='Процент прибыли' ` +
                        " value='0'> " +
                        "</p>");
                }));
            }
            else $('#open-invisible-owner-edit-list').addClass('display-none');

            $(".spinner").fadeOut('fast');
            $('#Order-edit-Modal').modal();

        },
        error: function (res) {
        },
    });
}

function fillOwnerEditForm(target) {
    $(".spinner").show();
    let owner_id = target.attr('itemid');
    $.ajax({
        url: "../components/selectors/User.php",
        type: "POST",
        dataType: 'JSON',
        data: {
            owner_id,
        },
        cache: false,
        success: function (res) {
            $('#edit-user-form #edit-user-title').text(`Изменить данные пользователя ${res['full_name']}`).attr('user-id', res['id']);
            $('#edit-user-form #editFirstNameField').val(res['first_name']);
            $('#edit-user-form #editLastNameField').val(res['last_name']);
            $('#edit-user-form #editLoginField').val(res['login']);
            $('#edit-user-form #editBranchField').val(res['branch_id']);
            $('#edit-user-form #editRoleField').val(res['role']);
            $('#edit-user-form #editMoneyField').val(res['money']);
            $(".spinner").fadeOut('fast');
            $('#Head-edit-Modal').modal();

        },
        error: function () {
        },
    });
}

function fillUserEditForm(target) {
    $(".spinner").show();
    let user_id = target.attr('itemid');
    $.ajax({
        url: "../components/selectors/User.php",
        type: "POST",
        dataType: 'JSON',
        data: {
            user_id,
        },
        cache: false,
        success: function (res) {
            $('#edit-user-form #edit-user-title').text(`Изменить данные пользователя ${res['full_name']}`).attr('user-id', res['id']);
            $('#edit-user-form #editFirstNameField').val(res['first_name']);
            $('#edit-user-form #editLastNameField').val(res['last_name']);
            $('#edit-user-form #editLoginField').val(res['login']);
            $('#edit-user-form #editBranchField').val(res['branch_id']);
            $('#edit-user-form #editRoleField').val(res['role']);
            $('#edit-user-form #editMoneyField').val(res['money']);
            $(".spinner").fadeOut('fast');
            $('#User-edit-Modal').modal();
        },
        error: function () {
        },
    });
}

function fillBranchEditForm(target) {
    $(".spinner").show();
    let branch_id = target.attr('itemid');
    $.ajax({
        url: "../components/selectors/Branch.php",
        type: "POST",
        dataType: 'JSON',
        data: {
            branch_id,
        },
        cache: false,
        success: function (res) {
            $('#edit-branch-form #edit-branch-title').text(`Изменить данные предприятия ${res['name']}`).attr('branch-id', res['id']);
            $('#edit-branch-form #editNameField').val(res['name']);
            $(".spinner").fadeOut('fast');
            $('#Branch-edit-Modal').modal();
        },
        error: function () {
        },
    });
}

function fillVGEditForm(target) {
    $(".spinner").show();
    let vg_id = target.attr('itemid');
    $.ajax({
        url: "../components/selectors/VG.php",
        type: "POST",
        dataType: 'JSON',
        data: {
            vg_id,
        },
        cache: false,
        success: function (res) {
            $('#edit-vg-form #edit-vg-title').text(`Изменить данные валюты ${res['name']}`).attr('vg-id', res['id']);
            $('#edit-vg-form #editNameField').val(res['name']);
            $('#edit-vg-form #editOutField').val(res['out']);
            $('#edit-vg-form #editInField').val(res['in']);
            $(".spinner").fadeOut('fast');
            $('#VG-edit-Modal').modal();

        },
        error: function () {
        },
    });
}

function fillOwnerEditForm(target) {
    $(".spinner").show();
    let owner_id = target.attr('itemid');
    $.ajax({
        url: "../components/selectors/Head.php",
        type: "POST",
        dataType: 'JSON',
        data: {
            owner_id,
        },
        cache: false,
        success: function (res) {
            $('#edit-vg-form #edit-vg-title').text(`Изменить валюту ${res['name']}`);
            $('#edit-vg-form #editNameField').attr('owner-id', res['id']);
            $('#edit-vg-form #editNameField').val(res['name']);
            $('#edit-vg-form #editOutField').val(res['out']);
            $('#edit-vg-form #editInField').val(res['in']);
            $('#edit-vg-form #editUrlField').val(res['url']);
            $(".spinner").fadeOut('fast');
            $('#Head-edit-Modal').modal();


        },
        error: function () {
        },
    });
}

function fillClientEditForm(target) {
    $(".spinner").show();
    let client_id = target.attr('itemid');
    $.ajax({
        url: "../components/selectors/Client.php",
        type: "POST",
        dataType: 'JSON',
        data: {
            client_id,
        },
        cache: false,
        success: function (res) {
            $('#edit-client-form #edit-client-title').text(`Изменить данные клиента ${res['full_name']}`).attr('client-id', res['id']);
            $('#edit-client-form #editFirstNameField').val(res['first_name']);
            $('#edit-client-form #editLastNameField').val(res['last_name']);
            $('#edit-client-form #editBynameField').val(res['login']);
            $('#edit-client-form #editPhoneField').val(res['phone']);
            $('#edit-client-form #editTgField').val(res['telegram']);
            $('#edit-client-form #editEmailField').val(res['email']);
            $('#edit-client-form #editDebtField').val(res['debt']);
            $('#edit-client-form #editRollbackField').val(res['rollback']);
            $('#edit-client-form #editDescriptionField').val(res['description']);
            $(".spinner").fadeOut('fast');
            $('#Client-edit-Modal').modal();


        },
        error: function () {
        },
    });
}


$('#Order-edit-Modal').on($.modal.CLOSE, function () {
        $('#Order-edit-Modal .edit-owner-percent-input-box ').remove();

})
$('#Order-Modal').on($.modal.CLOSE, function () {
    $('#Order-Modal .owner-percent-input-box ').remove();

})
function checkIfActive() {
    $.ajax({
        url: "../components/auth/activityCheck.php",
        type: "POST",
        data: "req=ok",
        cache: false,
        success: function (res) {
            if (res === "inactive") {
                window.location.href = '../index.php';
            } else {
                setTimeout(checkIfActive, 3000);
            }
        },
        error: function () {

        }
    });

};