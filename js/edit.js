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
            $('#paybackField').val(debtSum);
            break;
        case "#Rollback-Modal":
            $('[href*="#Rollback-Modal"]').first()[0].click();
            const referalList = $('#clientField');
            referalList.val(target.parent().parent().attr('defaultval'));
            const referalSelected = $("option:selected", referalList);
            const rollbackSum = referalSelected.attr('sum');
            $('#payField').val(rollbackSum);
            break;
        case "Head-edit":
            fillOwnersEditForm();
            alert('Head edit');
            break;
        case "Outgo-edit":
            alert('Outgo edit');
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
        case "Rollback-edit":
            fillRollbacksEditForm(mainParent);
            break;
        case "VG-edit":
            fillVGEditForm(mainParent);
            break;
        case "Debt-edit":
            alert('Debt edit');
            break;
        case "Order-edit":
            alert('Order edit');
            break;
        default:
            break;
    }

});




function fillRollbackEditForm(target) {
    createClick('[href="#VG-Modal"]');
}

function fillOrdersEditForm() {

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
            $('#edit-user-form #editBranchField').val( res['branch_id']);
            $('#edit-user-form #editRoleField').val(res['role']);
            $('#edit-user-form #editMoneyField').val(res['money']);
            $(".spinner").fadeOut('fast');
            createClick('[href="#User-edit-Modal"]');
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
            console.log(res);
            $('#edit-branch-form #edit-user-title').text(`Изменить данные пользователя ${res['name']}`).attr('branch-id', res['id']);
            $('#edit-branch-form #editNameField').val(res['name']);
            $(".spinner").fadeOut('fast');
            createClick('[href="#Branch-edit-Modal"]');

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
            $('#edit-vg-form #editUrlField').val(res['url']);
            $(".spinner").fadeOut('fast');
            createClick('[href="#VG-edit-Modal"]');

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
            createClick('[href="#VG-edit-Modal"]');

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
            $('#edit-client-form #editEmailField').val(res['email']);
            $('#edit-client-form #editDescriptionField').val(res['description']);
            $(".spinner").fadeOut('fast');
            createClick('[href="#Client-edit-Modal"]');

        },
        error: function () {
        },
    });
}

function createClick(target) {
    let linkEvent = document.createEvent('MouseEvents');
    linkEvent.initEvent('click', true, true);
    $(target)[0].dispatchEvent(linkEvent);
}