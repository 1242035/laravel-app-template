<?php

if (! function_exists('app_response')) {
    function app_response($data, $code = 200)
    {
        return response()->json($data, $code);
    }
}
