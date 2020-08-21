<?php

if( ! function_exists( 'api_response' ) )
{
    function api_response($data, $code = 200)
    {
        return response()->json($data, $code);
    }
}