$(document).ready(function () {
    $('#login-form').submit((e) => {
        e.preventDefault();
        let password = $("#clientPass").val();
        let login = $("#clientLogin").val();
        console.log(password, login);
        $('.spinner').show();
        $.ajax
        ({
            type: "GET",
            url: "./api/auth/clientAuth.php",
            username: login,
            contentType: "application/json; charset=utf-8",
            password: password,
            data: '{}',
            success: function (res) {
                if (res.error) {
                    switch (res.error) {
                        case "pass":
                            $("#clientPass").effect("shake");
                            break;
                        case "login":
                            $("#clientLogin").effect("shake");
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