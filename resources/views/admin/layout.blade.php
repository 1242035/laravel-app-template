<!doctype html>
<html lang="ja">
@include('admin.layouts.head')
<body>

@include('admin.layouts.header')

<div class="row" style="margin-right: 0 !important;">

    @include('admin.layouts.sidebar')

    <div class="content col-sm-9 col-xl-10">
        @yield('content')
    </div>

</div>
@include('admin.layouts.footer')
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@include('includes.custom-validation-rules')
@yield('script')

@include('includes.alert-message')
</body>
</html>
