$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
    }
});
$(() => {
    $('#form-status').on('change', function () {
        let oldVal = $(this).attr('data-initial_value');
        let newVal = $(this).val();
        $(this).attr('data-initial_value', newVal);
        if (newVal != oldVal) {
            $('#message-search').submit();
        }
    });
    $('.message-checkboxes').on('change', function () {
        if (this.checked) {
            if (confirm("Are you sure you want to confirm this message ?")) {
                $row_id = $(this).attr('data-message_id');
                let checkbox = this;
                $.ajax({
                    type: "POST",
                    url: confirmUrl + '/' + $row_id,
                    dataType: 'json',
                    success: function (data) {
                        $(checkbox).attr('disabled', true);
                    },
                    error: function (error) {
                        alert(error.responseJSON.error);
                        checkbox.checked = false;
                    },
                });
            } else {
                this.checked = false;
            }
        }
    });
});
