
$("form").submit(function (event) {
    if ($(this).hasClass("submitted")) {
        event.preventDefault();
    } else {
        // add loading icon
        $text = $(this).find(":submit").text();
        $(this).find(":submit").html('<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>' + $text);
        $(this).addClass("submitted");
    }
});



$(function() {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('lastTab', $(this).attr('href'));
    });

    var lastTab = localStorage.getItem('lastTab');

    if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
    }

});


$(".money").inputmask({
    alias: "numeric",
    groupSeparator: " ",
    autoGroup: true,
    digits: 0,
    digitsOptional: false,
    prefix: '',
    placeholder: "",
    rightAlign: false,
    autoUnmask: true,
    removeMaskOnSubmit: true,
    unmaskAsNumber: true
});


$.fn.getForm2obj = function() {
    var _ = {};
    $.map(this.serializeArray(), function(n) {
        const keys = n.name.match(/[a-zA-Z0-9_]+|(?=\[\])/g);
        if (keys.length > 1) {
            let tmp = _;
            pop = keys.pop();
            for (let i = 0; i < keys.length, j = keys[i]; i++) {
                tmp[j] = (!tmp[j] ? (pop == '') ? [] : {} : tmp[j]), tmp = tmp[j];
            }
            if (pop == '') tmp = (!Array.isArray(tmp) ? [] : tmp), tmp.push(n.value);
            else tmp[pop] = n.value;
        } else _[keys.pop()] = n.value;
    });
    return _;
}
