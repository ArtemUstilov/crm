$(document).ready(function () {
    $('#replenish-fiat-btn').click(function () {
        $(".spinner").show();
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
                $(".spinner").fadeOut('fast');
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
        $(".spinner").show();
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
                console.log(res);
                if (res == 'success-replenish') {
                    createAlertTable(res);
                } else {
                    createAlertTable();
                }
                $(".spinner").fadeOut('fast');
            },
            error: function () {
                createAlertTable();
                $(".spinner").fadeOut('fast');
            },

        })
        ;
    };


});