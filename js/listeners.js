$(document).ready(function () {
    $('#owners-lists-container').on('click', '#open-invisible-owner-list', () => {
        $('#owners-list-invisible').toggleClass('open');
        if ($('#owners-list-invisible').hasClass('open')) {
            $('#open-invisible-owner-list').html('Скрыть');
            $('#owners-list-invisible').animate({
                height: $('#owners-list-invisible').get(0).scrollHeight
            }, 1000, function () {
                $('#owners-list-invisible').height('auto');
            });
        } else {
            $('#open-invisible-owner-list').html('Показать всех');
            $('#owners-list-invisible').animate({
                height: '0px'
            }, 1000);

        }

    });
    $('#owners-lists-container').on('change', '.owner-percent-input', () => {
        $('.owner-percent-input').each(function () {
            $(this).attr('value', $(this).val());
        })
    });
    $('#login-form').submit((event) => {
        event.preventDefault();
        let password = $("#passwordField").val();
        let login = $("#loginField").val();
        // let rememberMe = $("#remember-me-check").prop("checked") ? "on" : "off";
        $this = $(".login-form-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/auth.php",
            type: "POST",
            data: {
                password: password,
                login: login
            },
            cache: false,
            success: function (res) {
                switch (res) {
                    case "success":
                        window.location.href = '../index.php';
                        break;
                    case "login":
                        alert("wrong login");
                        break;
                    case "pass":
                        alert("wrong pass");
                        break;
                    default:
                        alert(res);
                }

            },
            error: function () {
                alert("kek")
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    });

    $('#menu-burger').click(() => {

        if ($('#menu-burger').hasClass('menu-burger--active')) {
            $('#menu-burger').removeClass('menu-burger--active');
            $('#menu').removeClass('menu--open');
            $('#menu-invisible').removeClass('menu--open');
        } else {
            $('#menu-burger').addClass('menu-burger--active');
            $('#menu').addClass('menu--open');
            $('#menu-invisible').addClass('menu--open');

        }
    })
    $('.close-btn-box').click(() => {
        if ($('.custom-alert').hasClass('custom-alert--active'))
            $('.custom-alert').removeClass('custom-alert--active');
    })

})