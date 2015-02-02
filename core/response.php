<?php
class Response {

    public $httpHeader = '';
    public $body = '';

    public function __construct( $httpHeader, $body ) {
        $this->httpHeader = $httpHeader;
        $this->body = $body;
    }
    
    public static function serverError( $t ) {
        return new Response( 'HTTP/1.1 500 Server Error', $t );
    }
    public static function notFound( $t ) {
        return new Response( 'HTTP/1.1 404 Not Found', $t );
    }
    public static function badRequest( $o ) {
        return new Response( 'HTTP/1.1 400 Bad Request', $t );
    }
    public static function unauthorized(  ) {
        return new Response( 'HTTP/1.1 401 Unauthorized', $t );
    }
}
