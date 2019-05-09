$(document).ready(function () {
    $('#branch-t').click(function () {
        $(".spinner").show();
        $.ajax({
            url: "../components/selectors/getBranches.php",
            type: "POST",
            data: "req=ok",
            cache: false,
            dataType: 'JSON',
            success: function (res) {
                if ($('#Change-Branch-Modal #changeBranchField').empty()) {
                    $('#Change-Branch-Modal #changeBranchField').append(`<option selected disabled value = ${res['current']["id"]}>${res['current']["name"]}</option>`);
                    if (res['other'])
                        res['other'].forEach((el) => {
                            $('#Change-Branch-Modal #changeBranchField').append(`<option value = ${el["id"]}>${el["name"]}</option>`)
                        });
                }
                $(".spinner").fadeOut('fast');
                $('#Change-Branch-Modal').modal();
            },
            error: function () {

            },

        });

    })
    $.validate({
        form: '#change-branch-form',
        modules: '',
        lang: 'ru',
        onSuccess: function () {
            changeBranch();
            return false;
        }
    });

    function changeBranch() {
        $(".spinner").show();
        let branch_id = $('#Change-Branch-Modal #changeBranchField').val();
        $.ajax({
            url: "../components/modal-response/changeBranch.php",
            type: "POST",
            data: {branch_id},
            cache: false,
            success: function (res) {
                if (res == 'change-success') {
                    $.modal.close();
                    location.reload();
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
    function createAlertTable() {
        if ($('.custom-alert').hasClass('custom-alert--active'))
            $('.custom-alert').removeClass('custom-alert--active');
        if ($('.custom-alert').hasClass('bg-green')) $('.custom-alert').removeClass('bg-green');
                $('.custom-alert .alert-text-box').text('Что-то пошло не так. Попробуйте еще раз');


        setTimeout(function () {
            $('.custom-alert').addClass('custom-alert--active');
        }, 300);

    }
});