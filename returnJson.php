<?php

function returnJson($resultArray, $origin) {
    if(array_key_exists('callback', $_GET)){
        $json = $_GET['callback'] . "(" . json_encode($resultArray, JSON_UNESCAPED_UNICODE) . ");";
    } else {
        $json = json_encode($resultArray);
    }

    if ($origin == 'idp1.local' or $origin == 'idp2.local') {
        header("Access-Control-Allow-Origin: https://".$origin);
    }

    return $json;
    exit(0);
}