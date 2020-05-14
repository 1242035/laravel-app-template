let page;
let total_page;
let lineUserId;
let lastDatabaseMessageId;

function sendChat(event) {
    if (event.which == 13 && !event.shiftKey) {
        event.preventDefault();
        let replyUrl = "/admin/message/line/reply/" + lineUserId;
        let data = $("#chat-form").serialize();
        event.target.value = "";
        $.ajax({
            url: replyUrl,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('input[name="csrf-token"]').attr('value') },
            accepts: {
                json: 'application/json',
            },
            data: data,
            success: function (response) {
                let text = '<div class="row col-12 justify-content-end"><div class="row line-message-item tri-right right-in bg-green round mb-4 mr-4 ml-4 position-relative">' +
                    '<div class="content-message col-12"><p>' + response.chat_message.content + '</p></div>' +
                    '<div class="date-message ft-12" style="position: absolute;bottom: 10px; right:40px;">' + response.chat_message.date + '</div></div></div>';
                $('.message-content').append(text);
                $('.message-content').animate({
                    scrollTop: $('.message-content').get(0).scrollHeight
                }, 2);
            },
            error: function (error) {
                console.log(error);
                toastr.error(error.responseJSON.message);
            }

        });
    }
}

$("#chat-form").on("submit", function (e) {
    e.preventDefault();
});

$('#input-chat').on('keydown', sendChat);

$('.line-user-item').click(function (e) {

    let me = $(this);
    $('.header-message-detail img').attr('src', me.find('img.rounded-circle').attr('src'));
    $('.header-user-name').html(me.find('.line-user-item__name').html());
    lineUserId = $(this).find('.line-user-id').text();
    let url = "/admin/message/read-message/" + lineUserId;
    $.ajax({
        url: url,
        headers: { 'X-CSRF-TOKEN': $('input[name="csrf-token"]').attr('value') },
        accepts: {
            json: 'application/json',
        },
        method: 'POST',
        success: function (response) {
            lastDatabaseMessageId = response.last_message_id;
            page = response.current_page;
            total_page = response.total_page;
            me.removeClass('not-seen');
            $('.line-user-item.line-user-active').removeClass('line-user-active');
            me.addClass('line-user-active');
            me.find('span.badge').remove();
            $('.message-content').empty();
            $.each(response.data, function (index, value) {
                let text;
                if (value.sender_id != 0) {
                    text = '<div class="row col-12 justify-content-start"><div class="line-message-item tri-right left-in bg-white round mb-4 mr-4 ml-4 position-relative">';
                } else {
                    text = '<div class="row col-12 justify-content-end"><div class="row line-message-item tri-right right-in bg-green round mb-4 mr-4 ml-4 position-relative">';
                }
                if (value.type == 1) {
                    text += '<div class="content-message col-12"><p>' + value.message + '</p>';
                } else if (value.type == 2) {
                    text += '<div class="content-message col-12"><img height="300px" src="' + value.image + '">';
                } else {
                    text += '<div class="content-message col-12"><a href="' + value.message + '" download="">Download</a>'
                }
                text += '</div>' +
                    '                <div class="date-message ft-12" style="position: absolute;bottom: 10px; right:40px;">' + value.message_date + '</div>' +
                    '            </div></div>';
                $('.message-content').prepend(text);
            });
            if ($("#chat-form").hasClass('d-none')) {
                $("#chat-form").removeClass('d-none');
            }
            $('.message-content').animate({
                scrollTop: $('.message-content').get(0).scrollHeight
            }, 2);
        }
    });
});

$('.search-user').on('keypress', function (e) {
    $('.empty-user').addClass('d-none');
    let search = $(this).val();
    if (e.which == 13) {

        let empty_user = false;
        $('.line-user.d-none').removeClass('d-none');

        $('.line-user').each(function (index) {
            if ($(this).find('.line-user-item__name').text().toUpperCase().search(search.toUpperCase().trim()) < 0) {
                $(this).addClass('d-none');
            } else {
                empty_user = true;
            }
        });

        if (!empty_user) {
            $('.empty-user').removeClass('d-none');
        }

    }

});
let localtion = location.href.split('#')[0];

$('.message-content').on('scroll', function () {
    if ($('.message-content').scrollTop() == 0) {
        if (page < total_page) {
            page += 1;
            let url = "/admin/message/read-message/" + lineUserId + '?page=' + page;
            let checkId = true;
            let messageId = '';
            $.ajax({
                url: url,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('input[name="csrf-token"]').attr('value') },
                contentType: "application/x-www-form-urlencoded",
                data: { last_message_id: lastDatabaseMessageId },
                accepts: {
                    json: 'application/json',
                },
                success: function (response) {
                    page = response.current_page;
                    total_page = response.total_page;
                    let addedHeight = 0;
                    $.each(response.data, function (index, value) {
                        if (checkId == true) {
                            messageId = 'message-' + value.id;
                        }
                        checkId = false;
                        if (value.sender_id != 0) {
                            text = '<div class="row col-12 justify-content-start"><div class="row line-message-item tri-right left-in bg-white round mb-4 mr-4 ml-4 position-relative id="message-' + value.id + '"' + '>';
                        } else {
                            text = '<div class="row col-12 justify-content-end"><div class="row line-message-item tri-right bg-green right-in  round mb-4 mr-4 ml-4 position-relative  id="message-' + value.id + '"' + '>';
                        }
                        if (value.type == 1) {
                            text += '<div class="content-message col-12">' + value.message;
                        } else if (value.type == 2) {
                            text += '<div class="content-message col-12"><img height="300px" width="300px" src="' + value.image + '">';
                        } else {
                            text += '<div class="content-message col-12"><a href="' + value.message + '" download="">Download</a>'
                        }
                        text += '</div>' +
                            '                <div class="date-message ft-12" style="position: absolute;bottom: 10px; right:40px;">' + value.message_date + '</div>' +
                            '            </div></div>';
                        let addedEle = $(text).prependTo($('.message-content'));
                        addedHeight += addedEle.outerHeight();
                    });
                    $('.message-content').scrollTop(addedHeight);
                    location.href = localtion + '#' + messageId;
                }
            });
        }
    }
});

