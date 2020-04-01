(function ($) {
    "use strict"; // Start of use strict

    $('.login-form').each(function () {
        $(this).on('blur', function () {
            if ($(this).val().trim() !== "") {
                $(this).addClass('login-focused');
            } else {
                $(this).removeClass('login-focused');
            }
        })
    })

})(jQuery);

$(document).ready( function () {
    $('#dreamTable').DataTable({
        "pageLength": 25
    });

    $('#dvTicketsTable').DataTable({
        "pageLength": 25,
        "order": [[ 4, "desc" ]]
    });

    $('#dvComplaintsTable').DataTable({
        "pageLength": 25,
        "order": [[ 3, "desc" ]]
    });

    $('#dvUnbansTable').DataTable({
        "pageLength": 25,
        "order": [[ 3, "desc" ]]
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
});


