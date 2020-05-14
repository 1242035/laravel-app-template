 $(document).ready(function () {
      $('.btn-edit').click(function(event) {
        $('.img').addClass('btn-file');
      });

      $(document).on('click','.img.btn-file',function(e){
        $('.input-file').click();
      });

      $('.btn-edit').click(function(event) {
        $('.btn-edit').addClass('d-none');
        $('.btn-update').removeClass('d-none');
        $('.fas.fa-plus').hide();
      });
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('.btn-confirm').click(function(event) {
        let form = $('#form-image-photo')[0];
        let formData = new FormData(form);
        formData.append('photo', $('input[type=file]')[0].files[0]);
        let id = $('#id').val();
        $.ajax({
          type:'POST',
          url:'/admin/store/'+ id + '/update-stamp',
          data: formData,
          contentType: false,
          success:function(data){
            $('.btn-confirm').addClass('d-none');
            $('.btn-edit').removeClass('d-none');
            toastr.success(data.success, "成功");
          },
          cache: false,
          processData: false
        });
      });
    })

    function encodeImageFileAsURL(element) {
      var file = element.files[0];
      var reader = new FileReader();
      reader.onloadend = function() {
        $('.btn-file').css('background-image', 'url('+reader.result+')');
      }
      reader.readAsDataURL(file);
    }

    // var _URL = window.URL || window.webkitURL;
    // $("#photo").change(function (e) {
    //   var file, img;
    //   if ((file = this.files[0])) {
    //     img = new Image();
    //     img.onload = function () {
    //       $('#width').val(this.width);
    //       $('#height').val(this.height);
    //     };
    //     img.src = _URL.createObjectURL(file);
    //   }
    // });

    // jQuery.validator.addMethod('width', function (value, element) {
    //   if ($('#width').val()) {
    //     return $('#width').val() <= 400;
    //   }

    //   return true;
    // }, 'cần nhỏ hơn 400px');

    // jQuery.validator.addMethod('height', function (value, element) {
    //   if ($('#height').val()) {
    //     return $('#height').val() <= 400;
    //   }

    //   return true;
    // }, 'cần nhỏ hơn 400px...');

    let validateObj = {
     ignore: [],
     onkeyup: function(ele) {
      $(ele).valid();
    },
    rules: {
      photo: {
        required: true,
        extension: "jpeg,png",
        // width: true,
        // height:true
      }
    },
    messages: {
      photo: {
        required: '該当するデータがありません',
        extension: "画像形式はjpeg/pngである必要です"
      }
    },

  }
  let $form = $('#form-image-photo');
    $('.btn-update').click(function(event) {
      $('.btn-confirm').removeClass('d-none');
      $('.btn-update').addClass('d-none');
      $('.img').removeClass('btn-file');
  });