$('.link-border-bot').click(function () {
    $(this).parents('.link-store').find('.link-border-bot').removeClass('link-active');
    $(this).addClass('link-active');
});
$('.user-name').on('change', function () {
    $(this).valid();
});
$('body').click(function () {
    if ($('.store-name').val().length > 0) {
        $('.select2-results').addClass('d-none');
    } else {
        $('.select2-results').removeClass('d-none');
    }
});

$('.menu-1').click(function () {
    $('#menu-1').removeClass('d-none');
    $('#menu-1').addClass('d-block');
    $('#menu-2').removeClass('d-block');
    $('#menu-2').addClass('d-none');
});
$('.menu-2').click(function () {
    $('#menu-1').removeClass('d-block');
    $('#menu-1').addClass('d-none');
    $('#menu-2').removeClass('d-none');
    $('#menu-2').addClass('d-block');
});

$(function () {
    $('.date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().add(2,'years').format('YYYY'), 10),
    });
});

