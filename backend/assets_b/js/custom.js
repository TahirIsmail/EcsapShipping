$(document).ready(function() {



    /**********customer modal*** */
    $("body").delegate(".click_modal", "click", function() {
        $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));
        return false;

    });
    $("#modal").modal({
        show: false,
        backdrop: 'static',
        tabindex: false,
    });
    $('#modal').removeAttr('tabindex');
    //reports
    $("body").delegate(".click_modal_report", "click", function() {
        $('#modal-report').modal('show').find('#modalContentreport').load($(this).attr('value'));
        return false;

    });
    $("#click_modal_report").modal({
        show: false,
        backdrop: 'static',
        tabindex: false,
    });
    $('#click_modal_report').removeAttr('tabindex');
    $("#modal-report").modal({
        show: false,
        backdrop: 'static',
        tabindex: false,
    });
    $('#modal-report').removeAttr('tabindex');

    $("#print").click(function() {



        window.print();

        setTimeout(function() {
            $(".top_processes").css("visibility", "visible");
            $(".top_processes").css("height", "");
        }, 2000);

    });

});

$(document).ready(function() {
    $('.select2').on('change', function () {
        $(this).valid();
    });
})