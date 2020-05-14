"use strict";

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});

var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};
Upload.prototype.doUpload = function (url, progressHandling, onSuccess, onError) {
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);

    $.ajax({
        type: "POST",
        url: url,
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload && progressHandling) {
                myXhr.upload.addEventListener('progress', progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
            // your callback here
            if( onSuccess ){ onSuccess(data) }
        },
        error: function (error) {
            // handle error
            if( onError ){ onError(error) }
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

;(function ($) {
    var $root = $('#import-modal');

    var resetAlert = function() {
        $root.find('.form-alert').html('').addClass('d-none');
    }

    var resetProgress = function() {
        $root.find('.progress-start').text('');
        $root.find('.progress-end').text('');
        
        $root.find('.progress-bar').attr({
            'aria-valuenow': 0,
            'aria-valuemax': 0
        }).css({'width': '0%'}).text('');
        $root.find('.form-progress').addClass('d-none');
    }

    var resetForm = function() {
        $root.find('.btn-import-action').attr('disabled', false).find('span').addClass('d-none');
        var name = $root.find('.custom-file-label').attr('data-label');
        $root.find('.custom-file-input').val('');
        $root.find('.custom-file-input').attr('disabled', false);
        $root.find('.custom-file-label').text(name);
    }

    var reset = function() {
        resetForm();
        resetAlert();
        resetProgress();
    }

    var progressHandling = function (event) {
        var progress = $root.find('.form-progress');
        $(progress).removeClass('d-none');
        var processBar = $(progress).find('.progress-bar');
        var percent = 0;
        var position = event.current_index || 0;
        var total    = event.total || 0;
        
        if( total > 0 ) {
            percent = Math.ceil(position / total * 100);
        }
        
        // update progressbars classes so it fits your code
        $(progress).find('.progress-start').text(position);
        $(progress).find('.progress-end').text(total);
        $(processBar).attr({
            'aria-valuenow': position,
            'aria-valuemax': total
        }).css({'width': percent + '%'}).text(percent + '%');
    };

    var showMessage = function(message, type) {
        var klass = 'primary-'+type;
        $root.find('.form-alert').append('<div class="alert '+ klass+ '">' + message + '</div>').removeClass('d-none');
        setTimeout( function(){
            resetAlert();
        }, 10000);
    }

    var checkStatus = function( action , jobId) {

        $.post(action,{'job_id': jobId }, function(response) {
            progressHandling(response);
            if( !response || response.status != 3) {
                $root.find('.custom-file-input').attr('disabled', true);
                var timerId = setTimeout( function() {
                    checkStatus( action , jobId);
                }, 2500);
            }
            else {

                try{
                    window.clearTimeout( timerId );
                    //
                }catch(e){}
                showMessage('インポートしました', 'success');
                setTimeout( function() {
                    reset();
                    window.location.reload();
                }, 3000);
            }
        });
    }

    $(document).on('click', '.btn-import', function (event) {
        event.preventDefault();
        reset();
        var action = $(this).attr('data-action');
        var checkStatusAction = $(this).attr('data-check-status');
        if( !action || action.length <= 0 || !checkStatusAction || checkStatusAction.length <= 0 ){ return; }
        $root.find('.btn-import-action').attr('data-action', action);
        $root.find('.btn-import-action').attr('data-check-status', checkStatusAction);
        $root.modal('show');
    });

    $(document).on('change', '.custom-file-input', function() {
        var name = null;
        try {
            name = this.files[0].name
        }catch(e){}
        if( !name ) { 
            name = $(this).closest('.modal-body').find('.custom-file-label').attr('data-label')
        }
        $(this).closest('.modal-body').find('.custom-file-label').text(name);
    });

    $(document).on('click', '.btn-import-action', function () {
        var action = $(this).attr('data-action');
        var checkStatusAction = $(this).attr('data-check-status');
        if( !action || !checkStatusAction ){ return }
        var file = null;
        try{
            file = $('#validatedCustomFile')[0].files[0];
        }catch(e){
            //console.log(e)
        }
        if( !file ){ return; }
        $(this).attr('disabled', true).find('span').removeClass('d-none');
        $root.find('.custom-file-input').attr('disabled', true);
        var upload = new Upload(file);
        // execute upload
        upload.doUpload(action , progressHandling, function(data) {
            $root.find('.custom-file-input').attr('disabled', true);
            if( data && data.jobId ) {
                checkStatus(checkStatusAction, data.jobId);
            }
            else{
                $('.btn-import-action').attr('disabled', false).find('span').addClass('d-none');
            }
        }, function(error) {
            $('.btn-import-action').attr('disabled', false).find('span').addClass('d-none');
            $root.find('.custom-file-input').attr('disabled', false);
        });
    });

    $(document).on('click', '.btn-import-close', function () {
        reset();
        $('#import-modal').modal('hide');
    });

})(jQuery);
