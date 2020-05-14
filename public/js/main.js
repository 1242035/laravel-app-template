$(document).ready(function () {
    //sidebar admin

    let url = window.location.href.split('?')[0];
    if ($('#sidebar-admin').find('a[href="' + url + '"]').length > 0) {
        $('#sidebar-admin').find('a[href="' + url + '"]').addClass('sidebar__item__active')
        $('#sidebar-admin').find('a[href="' + url + '"]').parent().prev().addClass('sidebar__item__active');
        $('#sidebar-admin').find('a[href="' + url + '"]').parent().css('display', 'block');
    } else {
        $.each($('#sidebar-admin a'), function (index, value) {
            if (url.search($(this).attr('href')) > -1) {
                $(this).addClass('sidebar__item__active');
                $(this).parent().prev().addClass('sidebar__item__active');
                $(this).parent().css('display', 'block');
            }
            ;
        });
    }
    let dropdown = document.getElementsByClassName("dropdown-sidebar");
    let i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function () {
            this.classList.toggle("active");
            let dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }


    $('.cart-img').on('mouseenter', function () {
        $(this).find('img').attr('src', '/images/icon-cart-active.svg');
        $(this).css('color','red');
    });
    $('.cart-img').on('mouseleave', function () {
        if ($(this).find('.active').length < 1) {
            $(this).find('img').attr('src', '/images/icon-cart.svg');
        }
    });
    $('.cart-user').on('mouseenter', function () {
        $(this).find('img').attr('src', '/images/icon-user-active.svg');
    });
    $('.cart-user').on('mouseleave', function () {
        if ($(this).find('.active').length < 1) {
            $(this).find('img').attr('src', '/images/icon-user.svg');
        }
    });
    $('.cart-history').on('mouseenter', function () {
        $(this).find('img').attr('src', '/images/icon-cart-history-active.svg');
    });
    $('.cart-history').on('mouseleave', function () {
        if ($(this).find('.active').length < 1) {
            $(this).find('img').attr('src', '/images/icon-cart-history.svg');
        }
    });

    $(function () {
        $('.date-range-picker').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD'
            },
            singleDatePicker: true,
            showDropdowns: true,
            minYear: parseInt(moment().add(-1, 'years').format('YYYY'), 10),
            maxYear: parseInt(moment().add(10, 'years').format('YYYY'), 10),
        });
    });

    $('.date-range-picker-check-time').on('apply.daterangepicker', function (ev, picker) {
        let dateNow = new Date(moment().format('YYYY/MM/DD')).getTime();
        let startDate = new Date(picker.startDate.format('MM-DD-YYYY')).getTime();
        if (startDate < dateNow) {
            $(this).next().text('選択日は当日の後にしてください');
            $('.date-range-picker').val(moment().format('YYYY/MM/DD'))
        }else{
            $(this).next().text('');
        }
    });
});


// var opa = false;
// let opacity = function (id) {
//     $('#' + id).click(() => {
//         opa = !opa;
//         if (opa == true) {
//             $('body').css('opacity', '0.3')
//         } else {
//             $('body').css('opacity', '1')
//         }
//     });
//
//     $('#' + id).focusout(() => {
//         opa = false;
//         $('body').css('opacity', 1)
//     });
// };



