<?php
class Request {

    public static function get( $name = null ) {
        if( $name === null ) {
            return $_GET;
        }
        return isset( $_GET[ $name ] ) ? $_GET[ $name ] : null;
    }
    public static function post( $name = null ) {
        if( $name === null ) {
            return $_POST;
        }
        return isset( $_POST[ $name ] ) ? $_POST[ $name ] : null;
    }
}
