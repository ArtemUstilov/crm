$("#searchInput").keyup(function () {
    const data = this.value;
    const jo = $("#tbody").find("tr");
    jo.hide();
    jo.filter(function () {
        return $(this).is(":contains('" + data + "')");
    }).show();

}).focus(function () {
    this.value = "";
    $(this).css({
        "color": "black"
    });
    $(this).unbind('focus');
}).css({
    "color": "#C0C0C0"
});