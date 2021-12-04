$(function () {

    var timeout;
    var loading = false;
    var loaderClear;

    $(document).ajaxStart(function () {
        loading = true;
        timeout = setTimeout(function () {
            $("#loader").height($(document).height());
            if (loading == true)
                $("#loader").show();
        }, 250);

        loaderClear = setTimeout(function () {
            loading = false;
            $("#loader").hide()
        }, 60000);
    });


    $(document).ajaxStop(function () {
        loading = false;
        clearTimeout(timeout);
        $("#loader").hide()
    });


    $(document).on('click', '.dilSelect', function () {

        var lang = $(this).attr('id');

        $.post('index.php?r=site/language', {'lang': lang}, function (data) {
            location.reload();
        });
    });

    $(document).on('click', '.fc-day', function () {

        var date = $(this).attr('data-date');

        $.get('index.php?r=event/create', {'date': date}, function (data) {
            $('#modal').modal('show')
                .find('#modalContent')
                .html(data);
        });
    });

    $('#modalButton').click(function () {
        $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));
    });

    $(document).on("hidden.bs.modal", function (e) {
        $(e.target).removeData("bs.modal").find(".modal-content").empty();
    });
});