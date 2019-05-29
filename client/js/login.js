$(document).ready(function () {
    $('#login-form').submit((e) => {
        e.preventDefault();
        let password = $("#passwordField").val() ? $("#passwordField").val() : 0;
        let login = $("#loginField").val();
        console.log(login);
        $('.spinner').show();
        $.ajax
        ({
            type: "GET",
            url: "./api/auth/clientAuth.php",
            username: login,
            password: password,
            data: '{}',
            success: function (res) {
                console.log(res);
                if (res.error) {
                    switch (res.error) {
                        case "pass":
                            $("#passwordField").effect("shake");
                            break;
                        case "login":
                            $("#loginField").effect("shake");
                            break;
                    }
                }

            },
            error: function (res) {
                console.log(res);
            },
            complete: function () {
                $('.spinner').fadeOut('fast');
            }
        });

    });
});