$(document).ready(function () {
    const val = document.getElementById('username');
    console.log(val.innerText, localStorage.getItem('username'));
    if (val.innerText) {
        localStorage.setItem('username', val.innerText);
    } else {
        val.innerText = localStorage.getItem('username');
    }


    [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10].forEach(key => {
        $(`#${key}-i`).keyup(function () {
            const data = this.value;

            const jo = $("#tbody").find("tr");
            jo.hide();
            jo.filter(function checkRows() {
                return $(this).children(`.${key}-f`).is(":contains('" + data + "')");
            }).show();

        }).focus(function () {
            this.value = "";
            $(this).css({
                "color": "black"
            });
            $(this).unbind('focus');
        }).css({
            "color": "#C0C0C0"
        })
            .click(function () {
                $filled = null;
                $('input').each(function () {
                    if ($(this).prop('id') != `${key}-i`) {
                        this.value = '';
                    } else {
                        $filled = $(this);
                    }
                });
                if (this.value.length === 0) {
                    const jo = $("#tbody").find("tr");
                    jo.show();
                }
            });
    });
    $.validate({
        form: '#add-user-form',
        modules: 'security',
        lang: 'ru',
        onSuccess: function () {
            addUser();
            return false;
        }
    });

    function addUser() {
        let password = $("#add-user-form #passField").val();
        let login = $("#add-user-form #loginField").val();
        let first_name = $("#add-user-form #firstNameField").val();
        let last_name = $("#add-user-form #lastNameField").val();
        let branch = $("#add-user-form #branchField").val();
        let role = $("#add-user-form #roleField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/main/addUser.php",
            type: "POST",
            data: {
                password: password,
                login: login,
                first_name: first_name,
                last_name: last_name,
                branch: branch,
                role: role,
            },
            cache: false,
            success: function (res) {
                alert(res);
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

    }
});
