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


//User
    $.validate({
        form: '#add-order-form',
        modules: '',
        lang: 'ru',
        onSuccess: function () {
            addOrder();
            return false;
        }
    });

    $('#Order-Modal #vgField').change(function (e) {
        const optionSelected = $("option:selected", this);
        const perc = optionSelected.attr('percent');
        console.log(perc);
        $('#outField').val(perc);
    });
    function addOrder() {
        let client = $("#add-order-form #clientField").val();
        let rollback_1 = $("#add-order-form #rollback1Field").val();
        let rollback_2 = $("#add-order-form #rollback2Field").val();
        let vg = $("#add-order-form #svgField").val();
        let sum_vg = $("#add-order-form #sumVGField").val();
        let out = $("#add-order-form #outField").val();
        let obtain = $("#add-order-form #obtainingField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/main/addOrder.php",
            type: "POST",
            data: {
                client: client,
                rollback_1: rollback_1,
                rollback_2: rollback_2,
                sum_vg: sum_vg,
                out: out,
                obtain: obtain,
                vg: vg,
            },
            cache: false,
            success: function (res) {
                alert(res);
                createAlertTable(res, "Заказ");
            },
            error: function () {
                alert(res);
                createAlertTable("connectionError", "Заказ");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }

//Order


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

//Client

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

    $.validate({
        form: '#add-outgo-form',
        modules: 'security',
        lang: 'ru',
        onSuccess: function () {
            addOutgo();
            return false;
        },
        onError: function () {
        }
    });

    function addOutgo() {
        let sum = $("#add-outgo-form #sumField").val();
        let owner = $("#add-outgo-form #ownerField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        // console.log(sum)
        $.ajax({
            url: "../components/main/addOutgo.php",
            type: "POST",
            data: { owner, sum },
            cache: false,
            success: function (res) {
                createAlertTable(res, "Расход");
            },
            error: function () {
                createAlertTable("connectionError", "Расход");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }

    $.validate({
        form: '#add-vg-form',
        modules: 'security',
        lang: 'ru',
        onSuccess: function () {
            addVG();
            return false;
        },
        onError: function () {
        }
    });

    function addVG() {
        let name = $("#add-vg-form #nameField").val();
        let in_percent = $("#add-vg-form #inField").val();
        let out_percent = $("#add-vg-form #outField").val();
        let url = $("#add-vg-form #urlField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/main/addVG.php",
            type: "POST",
            data: {
                name: name,
                in: in_percent,
                out: out_percent,
                url: url,
            },
            cache: false,
            success: function (res) {
                alert(res);
                createAlertTable(res, "Валюта");
            },
            error: function () {
                createAlertTable("connectionError", "Валюта");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }


    //Payback


    $.validate({
        form: '#pay-rollback-form',
        modules: '',
        lang: 'ru',
        onSuccess: function () {
            payRollback();
            return false;
        },
        onError: function () {
        }
    });

    function payRollback() {
        let login = $("#pay-rollback-form #clientField").val();
        let number = $("#pay-rollback-form #payField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/main/payRollback.php",
            type: "POST",
            data: {
                login: login,
                number: number,
            },
            cache: false,
            success: function (res) {
                alert(res);
                createAlertTable(res, "Выплата");
            },
            error: function () {
                createAlertTable("connectionError", "Выплата");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }


    //Debt

    $.validate({
        form: '#payback-debt-form',
        modules: '',
        lang: 'ru',
        onSuccess: function () {
            paybackDebt();
            return false;
        },
        onError: function () {
        }
    });

    function paybackDebt() {
        let login = $("#payback-debt-form #debtorField").val();
        let number = $("#payback-debt-form #paybackField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/main/paybackDebt.php",
            type: "POST",
            data: {
                login: login,
                number: number,
            },
            cache: false,
            success: function (res) {
                alert(res);
                createAlertTable(res, "Погашение");
            },
            error: function () {
                createAlertTable("connectionError", "Погашение");
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
                    const span = $(this).children().first().children().first().children().last();
                    if ($(this).attr('aria-sort') === 'descending') {
                        span.addClass('fas fa-arrow-down');
                    } else if ($(this).attr('aria-sort') === 'ascending') {
                        span.addClass('fas fa-arrow-up');
                    }
                }, 10);
            })
        })
        $('tr').each(function () {
            const el = $(this);
            el.click(function () {
                el.toggleClass('clicked');

                function unclick() {
                    el.toggleClass('clicked');
                    window.removeEventListener('click', unclick);
                }

                setTimeout(() => window.addEventListener('click', unclick), 100);
            });
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
                $('.custom-alert .alert-text-box').text(`${text} с таким логином уже существует`);
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
