var bsAlert = function (title, text, type, dismissable) {

    var alert = '<div class="alert alert-' + type;

    if (dismissable === true) {
        alert += 'alert-dismissible';
    }

    alert += '" role="alert">';

    if (dismissable === true) {
        alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    }

    alert += '<strong>' + title + '</strong> ' + text;

    alert += '</div>';

    console.log(alert);

    return alert;

};

$(document).ready(function () {

});