$(document).ready(function () {

    $('#login-form').submit((event) => {
        event.preventDefault();
        let password = $("#passwordField").val();
        let login = $("#loginField").val();
        // let rememberMe = $("#remember-me-check").prop("checked") ? "on" : "off";
        $this = $(".login-form-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/auth/auth.php",
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
        } else {
            $('#menu-burger').addClass('menu-burger--active');
            $('#menu').addClass('menu--open');

        }
    })
    $('.close-btn-box').click(() => {
        if ($('.custom-alert').hasClass('custom-alert--active'))
            $('.custom-alert').removeClass('custom-alert--active');
    })

})