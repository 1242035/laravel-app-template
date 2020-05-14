<script>

    toastr.options = {
        newestOnTop: true,
        closeButton: true,
        progressBar: true,
        preventDuplicates: false,
        closeDuration: 0,
        timeOut: 5000, //default timeout,
    }
    ;
</script>

@if ($message = Session::get('success'))
    <script>
        toastr.success("{{$message}}", "{{trans('admin_message.success')}}");
    </script>
@endif

@if ($message = Session::get('error'))
    <script>
        toastr.error("{{$message}}", "{{trans('admin_message.error')}}");
    </script>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif
