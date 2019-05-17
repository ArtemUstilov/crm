$(document).ready(function () {
    $('#replenish-fiat-btn').click(function () {
        $('.loader').show();
        $.ajax({
            url: "../components/selectors/Fiat.php",
            type: "POST",
            data: "req=ok",
            cache: false,
            dataType: 'JSON',
            success: function (res) {
                if ($('#replenish-fiat-Modal #replenishFiatSelect').empty()) {
                    if (res)
                        res.forEach((el) => {
                            $('#replenish-fiat-Modal #replenishFiatSelect').append(`<option value = ${el["fiat_id"]}>${el["full_name"]}</option>`)
                        });
                }
                $('.loader').fadeOut('fast');
                $('#replenish-fiat-Modal').modal();
            },
            error: function () {

            },

        });

    })
    $.validate({
        form: '#replenish-fiat-form',
        modules: '',
        lang: 'ru',
        onSuccess: function () {
            replenishFiat();
            return false;
        }
    });

    function replenishFiat() {
        $('.loader').show();
        const fiat = $('#replenish-fiat-Modal #replenishFiatSelect').val();
        const sum = $('#replenish-fiat-Modal #replenishFiatSum').val();
        $.ajax({
            url: "../components/modal-response/replenishFiat.php",
            type: "POST",
            data: {
                fiat,
                sum,
            },
            cache: false,
            success: function (res) {
                if (res == 'success-replenish') {
                    createAlertTable(res);
                } else {
                    createAlertTable();
                }
                $('.loader').fadeOut('fast');
            },
            error: function () {
                createAlertTable();
                $('.loader').fadeOut('fast');
            },

        })
        ;
    };


});