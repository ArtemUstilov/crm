$(document).ready(function () {
    const val = document.getElementById('username');
    if (val.innerText) {
        localStorage.setItem('username', val.innerText);
    } else {
        val.innerText = localStorage.getItem('username');
    }
    let icon = $('#menu-burger > i');
    $('#menu-burger').click(function () {
        icon.toggleClass('fa-bars');
        icon.toggleClass('fa-times');
    })


    function yFixedTH() {
        const tableW = $(".table-wrapper");
        const table = $("#table-container");
        const tableOffset = table.offset().top;
        const $head = $("#table-container > thead");
        // const $fixedHeader = $("#header-empty");
        const $height = $head.height();
        // $fixedHeader.css({width: table.width()+'px', height: $height+'px'});
        const topOffset = $head.css("top");
        tableW.scroll(function () {
            const offset = $(this).scrollTop();
            if (offset > 3 && $head.css("position") !== "absolute") {
                // $fixedHeader.show();
                $head.css({position: 'absolute', width: table.width() + 'px'});
            } else if (offset === 3) {
                // $fixedHeader.hide();
                $head.css({position: 'static', width: table.width() + 'px'});
            }
            $head.css({'top': offset});
        });
    }


    function initFilters() {
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
                        if ($(this).prop('id') !== `${key}-i`) {
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
    };
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
                createAlertTable(res);
            },
            error: function () {
                alert(res);
                createAlertTable("connectionError");
                showAlertTable();
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
                showAlertTable();
            }
        });

    }

    function filterIcons() {
        $('th').each(function () {
            const _this = $(this);
            _this.click(function () {
                setTimeout(() => {
                    $('th').each(function () {
                        const span = $(this).children().first().children().first().children().last();
                        span.removeClass();
                    });
                    console.log($(this).attr('aria-sort'));
                    const span = $(this).children().first().children().first().children().last();
                    if ($(this).attr('aria-sort') === 'descending') {
                        span.addClass('fas fa-arrow-down');
                    } else if ($(this).attr('aria-sort') === 'ascending') {
                        span.addClass('fas fa-arrow-up');
                    }
                }, 10);
            })
        })
    }

    if ($("table").length > 0) {
        initFilters();
        yFixedTH();
        filterIcons();
    }

    function createAlertTable(alertType) {
        if( $('.custom-alert').hasClass('bg-green')) $('.custom-alert').removeClass('bg-green');
        switch (alertType) {
            case "exists":
                $('.custom-alert .alert-text-box').text('Пользователь с таким логином уже существует');
                break;
            case "success":
                $('.custom-alert .alert-text-box').text('Пользователь успешно добавлен');
                $('.custom-alert').addClass('bg-green');
                break;
            case "failed":
                $('.custom-alert .alert-text-box').text('Что-то пошло не так. Попробуйте еще раз');
                break;
            case "denied":
                $('.custom-alert .alert-text-box').text('Недостаточно прав доступа');
                break;
            case "empty":
                $('.custom-alert .alert-text-box').text('Введены не все данные');
                break;
            case "connectionError":
                $('.custom-alert .alert-text-box').text('Ошибка сети. Перезагрузите страницу и попробуйте еще раз');
                break;
        }
        $('.custom-alert').addClass('custom-alert--active');
        setTimeout(function () {
            if($('.custom-alert').hasClass('custom-alert--active'))
            $('.custom-alert').removeClass('custom-alert--active');
        }, 2500);

    }

    function showAlertTable() {

    }

});
