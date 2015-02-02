<?php

set_error_handler("handleError");

function handleError($errno, $errstr) {
    if( $errno <= E_WARNING ) {
        header($_SERVER['SERVER_PROTOCOL']." 500 Server Error");
        // $response = array(
        //     "error" => array(
        //         "message" => "Server Error: A fatal error occurred.",
        //         "details" => $errno . ": " . $errstr
        //     )
        // );
        echo "Server Error: A fatal error occurred." . $errno . ": " . $errstr;
        exit;
    }
}
