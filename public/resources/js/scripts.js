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

    const doUpdate = function () {
        $('.dv-countdown').each(function () {
            $('.dv-progress-bar').width('0%');
            const count = parseInt($(this).html());
            if (count !== 0) {
                $(this).html(count - 1);
            }
            if (count === 0) {
                $('.dv-message').remove()
            }
        });
    };

    // Schedule the update to happen once every second
    setInterval(doUpdate, 1000);

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


