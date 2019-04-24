$(document).ready(function () {

    $('#login-form').submit((event) => {
        event.preventDefault();
        let password = $("#passwordField").val();
        let login = $("#loginField").val();
       // let rememberMe = $("#remember-me-check").prop("checked") ? "on" : "off";
        $this = $(".login-form-submit");
        $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
        $.ajax({
            url: "../components/main/auth.php",
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
                    $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
                }, 300);
            }
        });

    })
})