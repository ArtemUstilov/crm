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
        let id = $("#add-head-form #nameField").val();
        $this = $(".modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/addHead.php",
            type: "POST",
            data: {
                user_id: id,
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
    $('#Order-Modal #sumVGField, #Order-Modal #outField').on('change paste keyup', function (e) {
        $('#Order-Modal #debtClField').val($('#Order-Modal #sumVGField').val() * $('#Order-Modal #outField').val() / 100);
    })
    $('#Order-edit-Modal #editSumVGField, #Order-edit-Modal #outField').on('change paste keyup', function (e) {
        $('#Order-edit-Modal #editDebtClField').val($('#Order-edit-Modal #editSumVGField').val() * $('#Order-edit-Modal #editOutField').val() / 100);
    })
    const vgcl = $('#Order-Modal #vgField, #Order-Modal #clientField');
    vgcl.change(function (e) {
        $('#Order-Modal #sumVGField').trigger('change');
        let vg_id = $('#Order-Modal #vgField').val();
        let client_id = $('#Order-Modal #clientField').val();
        if (!vg_id && !client_id) return;
        $.ajax({
            url: "../components/selectors/getLoginByVg.php",
            type: "GET",
            dataType: 'json',
            data: {
                vg_id, client_id,
            },
            cache: false,
            success: function (res) {
                if(res.loginByVg)
                    $('#Order-Modal #loginByVgField').val(res.loginByVg);
            },
            error: function () {
            },
            complete: function () {
            }
        });

        if (vg_id) {
            const optionSelected = $("option:selected", '#Order-Modal #vgField');
            const perc = optionSelected.attr('percent');
            $('#outField').val(perc);
        }
        if (!client_id || !vg_id) return;
        vgcl.prop('disabled', true);
        vgcl.addClass('no-drop');
        $('.loader').show();

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
                $('.loader').fadeOut('slow');
                vgcl.prop('disabled', false);
                vgcl.removeClass('no-drop');
            }
        });
    });

    let currentOrderForm;
    const clientInput = $('#Order-Modal #clientField');
    clientInput.change(function (e) {
        let client_id = $('#Order-Modal #clientField').val();
        if (client_id == -1) {
            $('#Client-Modal').modal();
        }
        currentOrderForm = $('#Order-Modal');
    });


    const clientEditInput = $('#Order-edit-Modal #editClientField');
    clientEditInput.change(function (e) {
        let client_id = $('#Order-edit-Modal #editClientField').val();
        if (client_id == -1) {
            $('#Client-Modal').modal();
        }
        currentOrderForm = $('#Order-edit-Modal');
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
        const callmaster = $("#add-order-form #callmasterField").val();
        const vg = $("#add-order-form #vgField").val();
        const sum_vg = $("#add-order-form #sumVGField").val();
        const out = $("#add-order-form #outField").val();
        const obtain = $("#add-order-form #obtainingField").val();
        const loginByVg = $("#add-order-form #loginByVgField").val();
        const descr = $("#add-order-form #commentField").val();
        const sharesEls = $("#add-order-form .owner-percent-input");
        const debtCl = $("#add-order-form #debtCLField").val();
        const fiat = $("#add-order-form #fiatField").val();
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
                sum_vg,
                out,
                obtain,
                vg,
                shares,
                debtCl,
                callmaster,
                descr,
                fiat,
                loginByVg,
            },
            cache: false,
            success: function (res) {
                try {
                    res = JSON.parse(res);
                    if (res['success'] == false) {
                        createAlertTable('success', "Заказ");
                        $('#Order-transaction-info-modal #error-url').text(res['url']).attr('href', res['url']);
                        $('#Order-transaction-info-modal').append(`<div>Код ошибки: ${res['code'] || "неизвестен"}</div>`)
                        $('#Order-transaction-info-modal').append(`<div>Ошибка: ${res['message'] || "неизвестна"}</div>`)
                        $('#Order-transaction-info-modal').modal({
                            fadeDuration: 500,
                            fadeDelay: 0
                        });
                    }
                } catch {
                    createAlertTable("success", "Заказ и транзакция");
                }

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

    $('#Order-transaction-info-modal').on('click', '.close-modal', function () {
        location.reload();
    })

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
        let telegram = $("#add-client-form #tgField").val();
        let description = $("#add-client-form #descriptionField").val();
        let callmaster = $("#add-client-form #callmasterField").val();
        let byname = $("#add-client-form #bynameField").val();
        let phone = $("#add-client-form #phoneField").val();
        let email = $("#add-client-form #emailField").val();
        let password = $("#add-client-form #passwordField").val();
        let payment_system = $("#add-client-form #payment_system").is(':checked');
        let pay_in_debt = $("#add-client-form #pay_in_debt").is(':checked');
        let pay_page = $("#add-client-form #pay_page").is(':checked');
        let max_debt = $("#add-client-form #maxDebtField").val();
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
                email: email,
                telegram: telegram, password, pay_in_debt, pay_page, payment_system, max_debt
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
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
                $('#Order-Modal').modal();
                createAlertTable(res, "Клиент");
            },
            error: function () {
                createAlertTable("connectionError", "Клиент");
            },
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
        let fiat = $("#add-outgo-form #fiatField").val();
        let descr = $("#add-outgo-form #commentField").val();
        $this = $(".modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/addOutgo.php",
            type: "POST",
            data: {owner, sum, description: descr, fiat},
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
        let prevId = $("#add-vg-form #nameVgnField").val();
        let name = $("#add-vg-form #nameField").val();
        let in_percent = $("#add-vg-form #inField").val();
        let out_percent = $("#add-vg-form #outField").val();
        let url = $("#add-vg-form #urlField").val();
        let key = $("#add-vg-form #keyField").val();
        $this = $(".modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/addVG.php",
            type: "POST",
            data: {
                name,
                prevId,
                in: in_percent,
                out: out_percent,
                url,
                key,
            },
            cache: false,
            success: function (res) {
                createAlertTable(res, "VG");
            },
            error: function () {
                createAlertTable("connectionError", "VG");
            },
            complete: function () {
                setTimeout(function () {
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    }


    //Fiat
    $.validate({
        form: '#add-fiat-form',
        modules: 'security',
        lang: 'ru',
        onSuccess: function () {
            addFiat();
            return false;
        },
        onError: function () {
        }
    });

    function addFiat() {
        let full_name = $("#add-fiat-form #fullNameFiatField").val();
        let name = $("#add-fiat-form #nameFiatField").val();
        let code = $("#add-fiat-form #codeField").val();
        $this = $(".modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/addFiat.php",
            type: "POST",
            data: {
                name,
                full_name,
                code,
            },
            cache: false,
            success: function (res) {
                createAlertTable(res, "Fiat");
            },
            error: function () {
                createAlertTable("connectionError", "Fiat");
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
        const input = $('#payField');
        $('#Rollback-Modal #fiatField').val(optionSelected.attr('fiat'));
        input.val(sum);
        input.attr('max', sum);
        input.attr('min', 0);
    });


    function payRollback() {
        let id = $("#pay-rollback-form #clientField").val();
        let number = $("#pay-rollback-form #payField").val();
        let fiat = $("#pay-rollback-form #fiatField").val();
        $this = $(".modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/payRollback.php",
            type: "POST",
            data: {
                id, fiat, number,
            },
            cache: false,
            success: function (res) {
                createAlertTable(res, "Откат");
            },
            error: function () {
                createAlertTable("connectionError", "Откат");
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
        const fiat = optionSelected.attr('fiat');
        const input = $('#paybackField');
        input.val(sum);
        $('#Debt-Modal #fiatField').val(fiat);
        input.attr('max', sum);
        input.attr('min', 0);
    });

    function paybackDebt() {
        let id = $("#payback-debt-form #debtorField").val();
        let number = $("#payback-debt-form #paybackField").val();
        let fiat = $("#payback-debt-form #fiatField").val();
        $this = $(".modal-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/modal-response/paybackDebt.php",
            type: "POST",
            data: {
                id,
                number,
                fiat,
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


    function createAlertTable(alertType, requestType) {
        if ($('.custom-alert').hasClass('custom-alert--active'))
            $('.custom-alert').removeClass('custom-alert--active');
        if ($('.custom-alert').hasClass('bg-green')) $('.custom-alert').removeClass('bg-green');
        switch (alertType) {
            case "exists":
                if (requestType == "VG")
                    $('.custom-alert .alert-text-box').text(`${requestType} с таким именем уже существует`);
                else
                    $('.custom-alert .alert-text-box').text(`${requestType} с таким логином уже существует`);
                break;
            case "success":
                $('.custom-alert .alert-text-box').text(`${requestType} успешно добавлен(о)`);
                $('.custom-alert').addClass('bg-green');
                $.modal.close();
                if(currentOrderForm && requestType == "Клиент")
                    currentOrderForm.modal();
                else
                    if (requestType != 'Заказ')
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                break;
            case "edit-success":
                $('.custom-alert .alert-text-box').text(`Изменения сохранены`);
                $('.custom-alert').addClass('bg-green');
                $.modal.close();
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
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
