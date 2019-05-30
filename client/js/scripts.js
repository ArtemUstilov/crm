let storage = [];
$(document).ready(function () {
    $('.loader').fadeOut();
    $('#login-btn').click(() => {
        $('.loader').show();
        const vgSum = $('#vg-sum').val();
        if (vgSum == "" || vgSum == " " || vgSum < 1) {
            if (!$('#pay-form').find('.alert-warning').length)
                $('#pay-form').append('<div class="alert alert-warning">\n' +
                    '  <strong>Ошибка! </strong>Введена некоректная сумма\n' +
                    '</div>');
            $('.loader').fadeOut();
            return;
        } else {
            $('#pay-form').find('.alert-warning').remove();
        }
        const login = $('#login').val();
        $.get('./api/getClientInfo.php', {login, vgSum}, (res) => {
            if (res.error) {
                if (!$('#pay-form').find('.alert').length)
                    $('#pay-form').append('<div class="alert alert-danger">\n' +
                        '  <strong>Ошибка! </strong>Неверный логин\n' +
                        '</div>');
                $('#login-box .input-group').effect("shake");
                $('.loader').fadeOut();
                return;
            } else {
                $('#pay-form').children('.alert-danger').remove();
                $('#login').attr('disabled', true);
                $('#login').parent().addClass('correct-info');
                $('#login-btn').remove();
            }
            parseLoginData(res);
            $('.loader').fadeOut();
        }, 'json');
    });

    $('#pass-btn').click(() => {
        $('.loader').show();
        const login = $('#login').val();
        const password = $('#pass').val();
        $.get('./api/approvePass.php', {login, password}, (res) => {
            if (res.error) {
                if (!$('#pay-form').find('.alert').length)
                    $('#pay-form').append('<div class="alert alert-danger">\n' +
                        '  <strong>Ошибка! </strong>Неверный пароль\n' +
                        '</div>');
                $('#pass-box .input-group').effect("shake");
                $('.loader').fadeOut();
                return;
            } else {
                $('#pay-form').children('.alert-danger').remove();
                $('#pass').attr('disabled', true);
                $('#pass-btn').remove();
                $('#pass-btn').parent().addClass('correct-info');
            }
            parsePassData();
            $('.loader').fadeOut();
        }, 'json');
    });
    $('#pay-in-debt-btn').click(function () {
        createDeal(true);
    });
    $('#pay-system-btn').click(function () {
        createDeal();
    });
});
// function calcSum(res){
//     const perc = $('#vg-types').find(":selected").attr('perc');
//     if(!perc)
//         return;
//     $('#fiat-sum').text(+perc * +$('#vg-sum').val());
// }
// function convertVgDataToList(data){
//     return data['vgs']
//         .map(row=> `<option value="${row['vg_id']}" perc="${row['out_percent']}">${row['name']}</option>`)
//         .join('\n');
// }
function parseLoginData(res) {
    $('#vg-sum').prop('disabled', true);
    $('#vg-sum').parent().addClass('correct-info');
    if (+res.paySystem) {
        $('#pass-box').show();
    }

    $('#payment-info').append(`<p id="vg-label"><b>Криптовалюта</b>: <span class="big-text">${res.vgName}</span></p>`);
    $('#payment-info').append(`<p id="sum-label"><b>Стоимость</b>: <span class="big-text">${res.sum}</span> <b>${res.fiatName}</b></p>`);

    storage = res;
}

function parsePassData() {
    if (+storage.debtLimit > 0) {
        if (+storage.debtLimit - +storage.sum < 0) {
            $('#debt-limit-label').text('Лимита оплаты долгом не достаточно');
        } else {
            $('#payment-info').append(`<p id="debt-limit-label"><b>Ваш лимит оплаты в долг:</b> <span class="big-text">${storage.debtLimit}</span> <b>${storage.fiatName}</b></p>`);
            $('#pay-in-debt-btn').show();
        }
        $('#pay-system-btn').show();
    } else {
        $('#debt-limit-label').text('Ваш лимит оплаты в долг исчерпан');
    }
}

function createDeal(debt = 0) {
    $('.loader').show();
    const login = $('#login').val();
    const password = $('#pass').val();
    const vg_sum = $('#vg-sum').val();
    $.get('./api/createDeal.php', {login, password, vg_sum, debt}, (res) => {
        if(res.error){
            switch(res.error){

            }
            $('.loader').fadeOut();
            return false;
        }
        if (!$('#pay-form').find('.alert-success').length)
            $('#pay-form').append('<div class="alert alert-success">\n' +
                '  <strong>Поздравляем! </strong>Транзакция прошла успешно\n' +
                '</div>');
        $('.loader').fadeOut();
    }, 'html');
}

