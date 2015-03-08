$(document).ready(function () {

    $('#btn-refresh-inbox').click(function (event) {

        event.preventDefault();

        var accountId = $(this).data('account');
        var url = (accountId === 0) ? Routing.generate('mails_fetch_all') : '';

        $(this).children('i').addClass('fa-spin');

        $.get(url, function (data) {
            /*window.location.reload();*/
        });

    });

    $('.mail-list li').click(function () {

        var id = $(this).data('id');
        var url = Routing.generate('mails_show', {
            mailId: id
        });

        window.location.href = url;

    });

});