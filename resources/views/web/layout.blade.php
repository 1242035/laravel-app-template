<!doctype html>
<html lang="ja">
@include('web.layouts.head')
<body class="body" id="webui-body">

@include('web.layouts.header')

@yield('content')

@include('web.layouts.footer')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet"/>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>

@yield('script')
@include('includes.alert-message')

</body>
</html>
