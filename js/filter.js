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
        $(".table-container").each(function () {
            const clone = $(this).find("#tbody > tr").first().clone();
            const _this = $(this);
            clone.attr('id', "spec");
            clone.css({visibility: 'hidden'});
            clone.children().each(function () {
                $(this).css({padding: '0', fontSize: '0px'});
            });
            _this.find("#tbody").append(clone);
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10].forEach(key => {
                _this.find(`#${key}-i`).keyup(function () {
                    const data = this.value;

                    const jo = _this.find("#tbody").find("tr");
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
                            const jo = _this.find("#tbody").find("tr");
                            jo.show();
                        }
                    });
            });
        });
    }

    function handle_mousedown(e) {
        if ('DIV' !== e.target.tagName) return;
        const my_dragging = {};
        my_dragging.pageX0 = e.pageX;
        my_dragging.pageY0 = e.pageY;
        my_dragging.elem = this;
        my_dragging.offset0 = $(this).offset();
        console.log();

        function handle_dragging(e) {
            const left = my_dragging.offset0.left + (e.pageX - my_dragging.pageX0);
            const top = my_dragging.offset0.top + (e.pageY - my_dragging.pageY0);
            $(my_dragging.elem)
                .offset({top: top, left: left});
        }

        const body = $('body');

        function handle_mouseup(e) {
            body
                .off('mousemove', handle_dragging)
                .off('mouseup', handle_mouseup);
        }

        body
            .on('mouseup', handle_mouseup)
            .on('mousemove', handle_dragging);
    }

    $('.modal/*.table-container*/').mousedown(handle_mousedown);
//Branch
    $.validate({
        form: '#add-branch-form',
        modules: '',
        lang: 'ru',
        onSuccess: function () {
            addBranch();
            return false;
        }
    });

    function addBranch() {
        let name = $("#add-branch-form #nameField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/addBranch.php",
            type: "POST",
            data: {
                name,
            },
            cache: false,
            success: function (res) {
                createAlertTable(res, "Предприятие");
            },
            error: function () {
                createAlertTable("connectionError", "Предприятие");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }


    //Head

    $.validate({
        form: '#add-head-form',
        modules: '',
        lang: 'ru',
        onSuccess: function () {
            addHead();
            return false;
        }
    });

    function addHead() {
        let [first_name, last_name] = $("#add-head-form #nameField").val().split(' ');
        let branch = $("#add-head-form #branchField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/addHead.php",
            type: "POST",
            data: {
                first_name,
                last_name,
                branch,
            },
            cache: false,
            success: function (res) {
                createAlertTable(res, "Владелец");
            },
            error: function () {
                createAlertTable("connectionError", "Владелец");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }

    $('tr').on('click', (e) => {
        const target = $(e.target);
        switch (target.attr('modal')) {
            case "#Debt-Modal":
                $('[href*="#Debt-Modal"]').first()[0].click();
                const debtorList = $('#debtorField');
                debtorList.val(target.parent().parent().attr('defaultval'));
                const debtorSelected = $("option:selected", debtorList);
                const debtSum = debtorSelected.attr('sum');
                $('#paybackField').val(debtSum);
                break;
            case "#Rollback-Modal":
                $('[href*="#Rollback-Modal"]').first()[0].click();
                const referalList = $('#clientField');
                referalList.val(target.parent().parent().attr('defaultval'));
                const referalSelected = $("option:selected", referalList);
                const rollbackSum = referalSelected.attr('sum');
                $('#payField').val(rollbackSum);
                break;
            case "Head-edit":
                alert('Head edit');
                break;
            case "Outgo-edit":
                alert('Outgo edit');
                break;
            case "User-edit":
                alert('User edit');
                break;
            case "Branch-edit":
                alert('Branch edit');
                break;
            case "Client-edit":
                alert('Client edit');
                break;
            case "Referal-edit":
                alert('Referal edit');
                break;
            case "VG-edit":
                alert('VG edit');
                break;
            case "Debt-edit":
                alert('Debt edit');
                break;
            case "Order-edit":
                alert('Order edit');
                break;
            default:
                break;
        }

    });

    //Order
    $.validate({
        form: '#add-order-form',
        modules: '',
        lang: 'ru',
        onSuccess: function () {
            addOrder();
            return false;
        }
    });

    const vgcl = $('#Order-Modal #vgField, #Order-Modal #clientField');
    vgcl.change(function (e) {
        let vg_id = $('#Order-Modal #vgField').val();
        let client_id = $('#Order-Modal #clientField').val();
        if (!vg_id && !client_id) return;
        if (vg_id) {
            const optionSelected = $("option:selected", '#Order-Modal #vgField');
            const perc = optionSelected.attr('percent');
            $('#outField').val(perc);
        }
        if (!client_id || !vg_id) return;
        vgcl.prop('disabled', true);
        vgcl.addClass('no-drop');
        $(".spinner").show();

        $.ajax({
            url: "../components/modal-response/getVGOwners.php",
            type: "POST",
            data: {
                vg_id, client_id
            },
            cache: false,
            success: function (res) {
                const container = $('#owners-lists-container');
                container.empty();
                container.append(res);
            },
            error: function () {
            },
            complete: function () {
                $(".spinner").fadeOut('slow');
                vgcl.prop('disabled', false);
                vgcl.removeClass('no-drop');
            }
        });
    });
    const clientInpt = $('#Order-Modal #clientField');
    clientInpt.change(function (e) {
        let client_id = $('#Order-Modal #clientField').val();
        if (client_id == -1) {
            const href = document.createElement('a');
            href.style.display = 'none';
            href.href = '#Client-Modal';
            href.rel = 'modal:open';
            document.body.appendChild(href);
            href.click();
            document.body.removeChild(href);
        }
    });
    const callmasterInpt = $('#Order-Modal #callmasterField');
    callmasterInpt.change(function (e) {
        let callmaster_id = callmasterInpt.val();
        if (callmaster_id) {
            $('#rollbacks-lists-container').css({display: 'grid'});
        } else {
            $('#rollbacks-lists-container').css({display: 'none'});
        }
    });

    function addOrder() {
        const client = $("#add-order-form #clientField").val();
        const rollback_1 = $("#add-order-form #rollback1Field").val();
        const rollback_2 = $("#add-order-form #rollback2Field").val();
        const callmaster = $("#add-order-form #callmasterField").val();
        const vg = $("#add-order-form #vgField").val();
        const sum_vg = $("#add-order-form #sumVGField").val();
        const out = $("#add-order-form #outField").val();
        const obtain = $("#add-order-form #obtainingField").val();
        const sharesEls = $("#add-order-form .owner-percent-input");
        const debtCl = $("#add-order-form #debtCLField").val();
        const allShares = [];
        sharesEls.each(function () {
            allShares.push({value: $(this).val(), owner_id: $(this).attr('owner-id')});
        });
        const shares = allShares.filter((el) => el.value > 0);
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/addOrder.php",
            type: "POST",
            data: {
                client,
                rollback_1,
                rollback_2,
                sum_vg,
                out,
                obtain,
                vg,
                shares,
                debtCl,
                callmaster,
            },
            cache: false,
            success: function (res) {
                createAlertTable(res, "Заказ");
            },
            error: function () {
                createAlertTable("connectionError", "Заказ");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }


//User

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
            url: "../components/modal-response/addUser.php",
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
            url: "../components/modal-response/addClient.php",
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
                if (res.includes('success')) {
                    const opt = document.createElement('option');
                    opt.value = res.substr(7);
                    opt.innerText = first_name + ' ' + last_name;
                    opt.selected = true;
                    $('#clientField').append(opt);
                    res = 'success';
                }
                createAlertTable(res, "Клиент");
            },
            error: function () {
                createAlertTable("connectionError", "Клиент");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
                $('[href*="#Order-Modal"]').first()[0].click();
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
            url: "../components/modal-response/addOutgo.php",
            type: "POST",
            data: {owner, sum},
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
            url: "../components/modal-response/addVG.php",
            type: "POST",
            data: {
                name: name,
                in: in_percent,
                out: out_percent,
                url: url,
            },
            cache: false,
            success: function (res) {
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
    $('#Rollback-Modal #clientField').change(function (e) {
        const optionSelected = $("option:selected", this);
        const sum = optionSelected.attr('sum');
        $('#payField').val(sum);
    });

    function payRollback() {
        let login = $("#pay-rollback-form #clientField").val();
        let number = $("#pay-rollback-form #payField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/payRollback.php",
            type: "POST",
            data: {
                login: login,
                number: number,
            },
            cache: false,
            success: function (res) {
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
    $('#Debt-Modal #debtorField').change(function (e) {
        const optionSelected = $("option:selected", this);
        const sum = optionSelected.attr('sum');
        $('#paybackField').val(sum);
    });

    function paybackDebt() {
        let login = $("#payback-debt-form #debtorField").val();
        let number = $("#payback-debt-form #paybackField").val();
        $this = $(".add-modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/paybackDebt.php",
            type: "POST",
            data: {
                login: login,
                number: number,
            },
            cache: false,
            success: function (res) {
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
