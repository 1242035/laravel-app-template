<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>LOGIN</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}" type="text/css">
  <script src="{{ asset('js/main.js') }}"></script>
  <style>
    .error-warning {
      font-size: 14px;
      color: red;
    }

    label.error {
      color: red;
      font-size: 13px;
    }

    .error_message {
      position: relative;
      color: red;
      bottom: 10px;
    }
  </style>
</head>
<body>
@include('admin.layouts.header')
<div class="content">
  <div class="content-login text-center">
    <div class="content__title ">L O G I N</div>
    <form id="admin-login" class="content__form color-border" action="{{ route('admin.login') }}" method="post">
      @csrf
      <div style="margin: 0 20px">
        <div class="content__form__title">Login</div>
        <hr class="hr-border">
        @if ($message = Session::get('fail'))
          <div class="error_message">
            <small>{{ $message }}</small>
          </div>
        @endif

        <div class="form-group">
          <label for="email">Email</label>
          <input class="form-control" type="text" id="email" name="email" value="{{ old('email') }}">
          @error('email')
            <span class="error-warning">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control" type="password" id="password" name="password">
          @if ($errors->has('password'))
            <span class="error-warning">{{ $errors->first('password') }}</span>
          @endif
        </div>
        <div class="form-group">
          <button class="form-control btn-submit btn-submit__login">Login</button>
        </div>
        <div class="mb-2">
          <input type="checkbox" id="remember" class="check-box" name="remember" value="1">
          <label for="remember">Remember me</label>
        </div>
      </div>
    </form>
  </div>
</div>

@include('admin.layouts.footer')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
@include('includes.custom-validation-rules')
<script>
  $(document).ready(function () {
    $('#admin-login').validate({
      // Rules
      rules: {
        email: {
          required: true,
          maxlength: 256,
          validateEmail: true
        },
        password: {
          required: true
        }
      },
      // Messages
      messages: {
        email: {
          required: "{{ __('validation.admin.general.required', ['field' => 'メールアドレス']) }}",
          maxlength: 'Please enter less than 50 characters'
        },
        password: {
          required: "{{ __('validation.admin.general.required', ['field' => 'パスワード']) }}",
        }
      }
    })

    $('input').focus(function () {
      $('.error_message, error-warning').remove()
    });

    $('.btn-submit').click(function () {
      if ($('.error_message').length) {
        $('.error_message').remove()
      }
      $('#password').val($('#password').val().trim())
      $('#email').val($('#email').val().trim())
    })
  })
</script>
</body>
</html>
