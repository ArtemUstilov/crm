$(document).ready(function () {

    let icon = $('#menu-burger > i');
    $('#menu-burger').click(function () {
        icon.toggleClass('fa-bars');
        icon.toggleClass('fa-times');
    });

    function yFixedNoJquerry() {
        const head = document.getElementById('table-head');
        if (window.innerWidth > 524) {
            document.getElementById('table-wrapper').addEventListener('scroll', function (e) {
                head.style.transform = 'translateY(' + this.scrollTop + 'px)';
            });
        }
    }

    function initFilters() {
        const clone = $("#tbody > tr").first().clone();
        clone.attr('id', "spec");
        clone.css({visibility: 'hidden'});
        clone.children().each(function () {
            $(this).css({padding: '0', fontSize: '0px'});
        })
        $("#tbody").append(clone);
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10].forEach(key => {
            $(`#${key}-i`).keyup(function () {
                const data = this.value;

                const jo = $("#tbody").find("tr");
                jo.hide();
                jo.filter(function checkRows() {
                    return $(this).children(`.${key}-f`).is(":contains('" + data + "')") || $(this).prop('id') === 'spec';
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
                createAlertTable(res, "Пользователь");
            },
            error: function () {
                alert(res);
                createAlertTable("connectionError", "Пользователь");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }

    $.validate({
        form: '#add-client-form',
        modules: 'security',
        lang: 'ru',
        onSuccess: function () {
            addClient();
            return false;
        },
        onError: function () {
        }
    });

    function addClient() {
        let first_name = $("#add-client-form #firstNameField").val();
        let last_name = $("#add-client-form #lastNameField").val();
        let description = $("#add-client-form #descriptionField").val();
        let callmaster = $("#add-client-form #callmasterField").val();
        let byname = $("#add-client-form #bynameField").val();
        let phone = $("#add-client-form #phoneField").val();
        let email = $("#add-client-form #emailField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/main/addClient.php",
            type: "POST",
            data: {
                byname: byname,
                callmaster: callmaster,
                first_name: first_name,
                last_name: last_name,
                description: description,
                phone: phone,
                email: email
            },
            cache: false,
            success: function (res) {
                alert(res);
                createAlertTable(res, "Клиент");
            },
            error: function () {
                createAlertTable("connectionError", "Клиент");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
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
        yFixedNoJquerry();
        filterIcons();
    }

    function createAlertTable(alertType, text) {
        alert(text);
        if ($('.custom-alert').hasClass('custom-alert--active'))
            $('.custom-alert').removeClass('custom-alert--active');
        if ($('.custom-alert').hasClass('bg-green')) $('.custom-alert').removeClass('bg-green');
        switch (alertType) {
            case "exists":
                $('.custom-alert .alert-text-box').text(`${text}с таким логином уже существует`);
                break;
            case "success":
                $('.custom-alert .alert-text-box').text(`${text} успешно добавлен`);
                $('.custom-alert').addClass('bg-green');
                let linkEvent = document.createEvent('MouseEvents');
                linkEvent.initEvent('click', true, true);
                $('.close-modal')[0].dispatchEvent(linkEvent);
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

        setTimeout(function () {
            $('.custom-alert').addClass('custom-alert--active');
        }, 300);

    }


});
