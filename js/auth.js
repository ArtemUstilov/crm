$('#login-form').submit((event) => {
    console.log("SSSSSSSS");
    event.preventDefault();
    if ($("#passwordField").val().length == 0 || $("#loginField").val().length == 0) return;
    $('.loader').show();
    let password = $("#passwordField").val();
    let login = $("#loginField").val();
    // let rememberMe = $("#remember-me-check").prop("checked") ? "on" : "off";
    $this = $(".login-form-submit");
    $this.prop("disabled", true);
    $.ajax({
        url: "../api/auth/auth.php",
        type: "POST",
        data: {
            password: password,
            login: login
        },
        dataType: "JSON",
        cache: false,
        success: function (res) {
            $('.loader').fadeOut('fast');
            switch (res.error || res.status) {
                case 'sales':
                    window.location.href = '../content/orders.php';
                    break;
                case "success":
                    window.location.href = '../index.php';
                    break;
                case "login":
                    $('.login-form #loginField').addClass('shaking');
                    setTimeout(function () {
                        $('.login-form #loginField').removeClass('shaking');
                        setTimeout
                    }, 1000);
                    break;
                case "pass":
                    $('.login-form #passwordField').addClass('shaking');
                    setTimeout(function () {
                        $('.login-form #passwordField').removeClass('shaking');
                        setTimeout
                    }, 1000);
                    break;
                case "inactive":
                    $('#user-inactive-modal').modal();
                    break;

            }

        },
        error: function () {
        },
        complete: function () {
            setTimeout(function () {
                $this.prop("disabled", false);
            }, 300);
        }
    });

});