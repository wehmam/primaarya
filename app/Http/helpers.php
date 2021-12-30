<?php 

if(!function_exists("responseCustom")) {
    function responseCustom($data = [], $status = false) {
        return response([
            "status" => $status,
            "data"   => $data
        ]);
    }
}