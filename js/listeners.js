$(document).ready(function () {
    let icon = $('#menu-burger > i');
    $('#menu-burger').click(function () {
        icon.toggleClass('fa-bars');
        icon.toggleClass('fa-times');
    });

    $('#owners-lists-container').on('click', '#open-invisible-owner-list', () => {
        $('#owners-list-invisible').toggleClass('open');
        if ($('#owners-list-invisible').hasClass('open')) {
            $('#open-invisible-owner-list').html('Скрыть');
            $('#owners-list-invisible').animate({
                height: $('#owners-list-invisible').get(0).scrollHeight
            }, 1000, function () {
                $('#owners-list-invisible').height('auto');
            });
        } else {
            $('#open-invisible-owner-list').html('Показать всех');
            $('#owners-list-invisible').animate({
                height: '0px'
            }, 1000);

        }

    });
    $('#owners-lists-container').on('change', '.owner-percent-input', () => {
        $('.owner-percent-input').each(function () {
            $(this).attr('value', $(this).val());
        })
    });
    $('#login-form').submit((event) => {
        event.preventDefault();
        let password = $("#passwordField").val();
        let login = $("#loginField").val();
        // let rememberMe = $("#remember-me-check").prop("checked") ? "on" : "off";
        $this = $(".login-form-submit");
        $this.prop("disabled", true);
        $.ajax({
            url: "../components/auth/auth.php",
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
                    $this.prop("disabled", false);
                }, 300);
            }
        });

    });

    $('#menu-burger').click(() => {

        if ($('#menu-burger').hasClass('menu-burger--active')) {
            $('#menu-burger').removeClass('menu-burger--active');
            $('#menu').removeClass('menu--open');
            $('#menu-invisible').removeClass('menu--open');
        } else {
            $('#menu-burger').addClass('menu-burger--active');
            $('#menu').addClass('menu--open');
            $('#menu-invisible').addClass('menu--open');

        }
    })
    $('.close-btn-box').click(() => {
        if ($('.custom-alert').hasClass('custom-alert--active'))
            $('.custom-alert').removeClass('custom-alert--active');
    })

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

    if ($("table").length > 0) {
        initFilters();
        yFixedNoJquerry();
        filterIcons();
    }
})