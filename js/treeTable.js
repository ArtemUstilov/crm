$(document).ready(() => {
    if (!window.location.pathname.includes('types')){
        return;
    }
    $('#wrapper').css({overflowX: "visible"});
    initTable();
    fetchTypes();
    $('.change_isactive').change(function (res) {
        if ($(this).attr('checked'))
            deactivate(this, res);
        else
            activate(this, res);
    });
});


function levelToHtml(types, acc = 0) {
    let html = "";
    if (!types || !types.length) return html;
    acc && (html += `<ul class="submenu" id="${acc}">`);
    html += types.map(type => {
        if (Object.keys(type.node).length < 2) return;
        let s = appendType(type.node, type.children && type.children.length);

        s += levelToHtml(type.children, acc + 1);
        s += '</li>\n';
        return s;
    }).join('');
    acc && (html += '</ul>\n');
    return html;
}

function appendType({name, id, status}, hasChildren) {
    let s = `<li itemid="${id}">
            <div class="row-wrapper">
            <div>
            <i class="fas fa-edit"></i>
            <i class="fas fa-plus"></i>
             <span>${name}</span>
             </div>
             ${hasChildren ? `
<i class="fas fa-arrow-down"></i>` : ""}
             <span>
                <div class="button b2" id="button-10">
                <input type="checkbox" class="checkbox change_isactive" ${status === 1 ? "" : "checked"}>
                <div class="knobs"></div>
                </div>
                </span>
              </div>

            `;
    return s;
}

function fetchTypes() {
    const mockData = [
        {node:{id:1, name: "first", status: 1}, children: [
            {node:{id:2, name: "sec", status: 1}, children:
                    [{node:{id:3, name: "third", status: 0}},{node:{id:4, name: "fourth", status: 0}}]
            }]
        },
    ];
    $('#types-list').html(levelToHtml(mockData));
    // $(".loader").show();
    // $.ajax({
    //     url: "../api/select/outgoTypes.php",
    //     type: "POST",
    //     data: {},
    //     dataType: "JSON",
    //     cache: false,
    //     success: function (res) {
    //         if (res.error) {
    //             createAlertTable(res.error);
    //             return;
    //         }
    //
    //     },
    //     error: function () {
    //         createAlertTable("connectionError", "Типы расходов");
    //     },
    //     complete: function (res) {
    //         $(".loader").fadeOut("slow");
    //     }
    // });
}


function initTable() {
    (function () {
        let pluginName = "jqueryAccordionMenu";
        let defaults = {
            speed: 300,
            showDelay: 0,
            hideDelay: 0,
            singleOpen: true,
            clickEffect: true
        };

        function Plugin(element, options) {
            this.element = element;
            this.settings = $.extend({},
                defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.init()
        }

        $.extend(Plugin.prototype, {
            init: function () {
                this.openSubmenu();
                this.submenuIndicators();
                if (defaults.clickEffect) {
                    this.addClickEffect()
                }
            },
            openSubmenu: function () {
                $(this.element).find("div").children("ul").find("li").bind("click touchstart",
                    function (e) {
                        if (['I', 'SPAN', 'INPUT'].includes(e.target.tagName)) return;
                        e.stopPropagation();
                        e.preventDefault();
                        console.log($(this).children());
                        if ($(this).children(".submenu").length > 0) {
                            console.log("SSSS");
                            if ($(this).children(".submenu").css("display") === "none") {
                                $(this).children(".submenu").delay(defaults.showDelay).slideDown(defaults.speed);
                                return false
                            } else {
                                $(this).children(".submenu").delay(defaults.hideDelay).slideUp(defaults.speed)
                            }
                            if ($(this).children(".submenu").siblings("a").hasClass("submenu-indicator-minus")) {
                                $(this).children(".submenu").siblings("a").removeClass("submenu-indicator-minus")
                            }
                        }
                    })
            },
            submenuIndicators: function () {
                if ($(this.element).find(".submenu").length > 0) {
                    $(this.element).find(".submenu").siblings("a").append("<span class='submenu-indicator'>+</span>")
                }
            },
            addClickEffect: function () {
                let ink, d, x, y;
                $(this.element).find("a").bind("click touchstart",
                    function (e) {
                        $(".ink").remove();
                        if ($(this).children(".ink").length === 0) {
                            $(this).prepend("<span class='ink'></span>")
                        }
                        ink = $(this).find(".ink");
                        ink.removeClass("animate-ink");
                        if (!ink.height() && !ink.width()) {
                            d = Math.max($(this).outerWidth(), $(this).outerHeight());
                            ink.css({
                                height: d,
                                width: d
                            })
                        }
                        x = e.pageX - $(this).offset().left - ink.width() / 2;
                        y = e.pageY - $(this).offset().top - ink.height() / 2;
                        ink.css({
                            top: y + 'px',
                            left: x + 'px'
                        }).addClass("animate-ink")
                    })
            }
        });
        $.fn[pluginName] = function (options) {
            this.each(function () {
                if (!$.data(this, "plugin_" + pluginName)) {
                    $.data(this, "plugin_" + pluginName, new Plugin(this, options))
                }
            });
            return this
        }
    })();

    $(document).ready(function () {
        jQuery("#jquery-accordion-menu").jqueryAccordionMenu();

    });
    $(function () {
        $("#hall-list li").click(function () {
            $("#hall-list li.active").removeClass("active");
            $(this).addClass("active");
        })
    })
}

function activate(_this) {
    const row = $(_this).parent().parent();
    const a = $(_this).parent();
    const hall_name = row.attr('itemid');
    $.ajax
    ({
        type: "POST",
        url: "../backend/api/update/hall_active.php",
        dataType: 'JSON',
        data: {
            hall_name, is_active: 1,
        },
        success: function (res) {
            if (res.status === 'success'){

            } else
                $(_this).effect('shake');
        },
        error: function (e) {
            $(_this).effect('shake');
        }
    });
}

function deactivate(_this) {
    const row = $(_this).parent().parent();
    const a = $(_this).parent();
    const hall_name = row.attr('itemid');
    $.ajax
    ({
        type: "POST",
        url: "../backend/api/update/typeActive.php",
        dataType: 'JSON',
        data: {
            hall_name, is_active: 0,
        },
        success: function (res) {
            if (res.status === 'success') {

            } else
                $(_this).effect('shake');
        },
        error: function (e) {
            $(_this).effect('shake');
        }
    });
}