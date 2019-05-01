$(document).ready(function () {
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
        $this = $(".modal-submit");
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
        $this = $(".modal-submit");
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
        $this = $(".modal-submit");
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
        $this = $(".modal-submit");
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
        $this = $(".modal-submit");
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


    //Outgo
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
        $this = $(".modal-submit");
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


    //VG
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
        $this = $(".modal-submit");
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
        $this = $(".modal-submit");
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
        $this = $(".modal-submit");
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