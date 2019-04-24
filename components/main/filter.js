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
    })

});