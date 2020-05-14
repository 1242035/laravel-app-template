$('.link-border-bot').click(function () {
    $(this).parents('.link-store').find('.link-border-bot').removeClass('link-active');
    $(this).addClass('link-active');
});

let search_deposit, search_withdraw;

$('.menu-1').click(function () {
    $('#menu-1').removeClass('d-none');
    $('#menu-2').removeClass('d-block');
    $('#menu-1').addClass('d-block');
    $('#menu-2').addClass('d-none');
    $('.search-input').val(search_deposit);
});

$('.menu-2').click(function () {
    $('#menu-2').removeClass('d-none');
    $('#menu-1').removeClass('d-block');
    $('#menu-2').addClass('d-block');
    $('#menu-1').addClass('d-none');
    $('.search-input').val(search_withdraw);
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    let search = $('.search-input').val();
    let url = $(this).attr('href') + '&search=' + search;
    if (format_picker && format_picker == "YYYY/MM") {
        url += '&filter=month'
    }
    $.ajax({
        url: url,
        method: 'GET',
        success: function (result) {
            if (url.search('withdrawal') > -1) {
                if (result.menu1) {
                    if ($('#menu-1').hasClass('d-none')) {
                        $('#menu-2').html(result.menu1);
                    } else {
                        $('#menu-1').html(result.menu2);
                    }
                } else {
                    $('#menu-2').html(result);
                }
            } else {
                if (result.menu1) {
                    if ($('#menu-1').hasClass('d-none')) {
                        $('#menu-2').html(result.menu1);
                    } else {
                        $('#menu-1').html(result.menu2);
                    }
                } else {
                    $('#menu-1').html(result);
                }
            }
        }
    })
});

$(document).on('keypress', '.search-input', function (e) {
    let search = $(this).val();
    let search_option = $('#search-option').val();
    if ($('#menu-1').hasClass('d-none')) {
        search_withdraw = $(this).val();
    } else {
        search_deposit = $(this).val();
    }
    if (e.which == 13) {
        let url = "/admin/detailMoney?search=" + search + '&filter=' + search_option;

        if ($('#menu-1').hasClass('d-none')) {
            url += '&withdrawal=1';
        }
        $.ajax({
            url: url,
            method: 'GET',
            success: function (result) {
                if (result.menu1) {
                    if ($('#menu-1').hasClass('d-none')) {
                        $('#menu-2').html(result.menu1);
                    } else {
                        $('#menu-1').html(result.menu2);
                    }
                } else {
                    if ($('#menu-1').hasClass('d-none')) {
                        $('#menu-2').html(result);
                    }
                    if ($('#menu-2').hasClass('d-none')) {
                        $('#menu-1').html(result);
                    }
                }
            }
        })
    }
});

let format_picker = 'YYYY/MM/DD';

$('#search-option').change(function () {
    let search_input = $('#search-option').val();
    $('.search-input').val('');
    search_deposit = search_withdraw = '';
    let url = "/admin/detailMoney?filter=" + search_input;

    if ($('#menu-1').hasClass('d-none')) {
        url += '&withdrawal=1';
    }
    $.ajax({
        url: url,
        method: 'GET',
        success: function (result) {
            $('#menu-2').html(result.menu1);
            $('#menu-1').html(result.menu2);
        }
    });
    if (search_input == 'day') {
        format_picker = 'YYYY/MM/DD';
    } else {
        format_picker = 'YYYY/MM';
    }
});

$(function () {
    $('.choice-date').daterangepicker({
        locale: {
            format: format_picker
        },
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().add(-1, 'years').format('YYYY'), 10),
        maxYear: parseInt(moment().add(10, 'years').format('YYYY'), 10),
    });
});

$(document).on('keypress', '.choice-date', function (e) {
    let me = $(this);
    let search = $('.search-input').val();
    let search_option = $('#search-option').val();

    if (e.which == 13) {
        let url = "/admin/detailMoney?search=" + search + '&filter=' + search_option;
        if ($('#menu-1').hasClass('d-none')) {
            url += '&withdrawal=1';
        }

        $.ajax({
            url: url,
            method: 'GET',
            success: function (result) {
                me.val('');
                if (result.menu1) {
                    if ($('#menu-1').hasClass('d-none')) {
                        $('#menu-2').html(result.menu1);
                    } else {
                        $('#menu-1').html(result.menu2);
                    }
                } else {
                    if ($('#menu-1').hasClass('d-none')) {
                        $('#menu-2').html(result);
                    }
                    if ($('#menu-2').hasClass('d-none')) {
                        $('#menu-1').html(result);
                    }
                }
            }
        })
    }
});

$('.choice-date').on('apply.daterangepicker', function (ev, picker) {
    let date = picker.startDate.format(format_picker);
    let search = $('.search-input').val();
    let url = "/admin/detailMoney?search=" + search + '&date=' + date;
    if ($('#menu-1').hasClass('d-none')) {
        url += '&withdrawal=1';
    }

    $.ajax({
        url: url,
        method: 'GET',
        success: function (result) {
            if ($('#menu-1').hasClass('d-none')) {
                $('#menu-2').html(result);
            }
            if ($('#menu-2').hasClass('d-none')) {
                $('#menu-1').html(result);
            }
        }
    })
});

