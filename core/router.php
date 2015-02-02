<?php

class Router
{

    public static $routes = array();

    public static $methods = array();

    public static $callbacks = array();

    public static $patterns = array(
        ':any' => '([^/]+)',
        ':num' => '([0-9]+)',
        ':all' => '(.*)'
    );

    public static $error_callback;

    /**
     * Defines a route w/ callback and method
     */
    public static function __callstatic($method, $params) {

        $uri = dirname($_SERVER['PHP_SELF']).$params[0];
        $callback = $params[1];

        array_push(self::$routes, $uri);
        array_push(self::$methods, strtoupper($method));
        array_push(self::$callbacks, $callback);
    }

    /**
     * Defines callback if route is not found
    */
    public static function error($callback) {
        self::$error_callback = $callback;
    }

    /**
     * Runs the callback for the given request
     */
    public static function dispatch() {

        $found_route = false;
        $error = false;
        $return = null;

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        
        // trim trailing
        if( $uri != "/" && substr( $uri, -1 ) == "/" ) {
            $uri = substr($uri,0,-1);
        }

        $searches = array_keys(static::$patterns);
        $replaces = array_values(static::$patterns);

        $pos = 0;
        $return = null;
        foreach (self::$routes as $route) {
            if (strpos($route, ':') !== false) {
                $route = str_replace($searches, $replaces, $route);
            }
            if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                if (self::$methods[$pos] == $method) {
                    array_shift($matched);
                    $return = Router::loadController( self::$callbacks[$pos], $matched );
                }
            }
            if( $return != null ) {
                break;
            }
            $pos++;
        }

        // no routes
        if( $return == null ) {
            $return = Router::loadController( self::$error_callback, array( 'No routes found.') );
        }

        if( $return !== null ) {
            if( gettype( $return ) == 'object' && get_class( $return ) == 'Response' ) {
                header($return->httpHeader);
                echo $return->body;
            } else {
                echo $return;
            }
        }
    }

    public static function loadController( $controller, $parameters = array() ) {

        $parts = explode('@',$controller);
        $file = strtolower('controllers/'.$parts[0].'.php');

        //try to load and instantiate model
        if(file_exists($file)){
            require $file;
        }

        //instanitate controller
        $controllerObj = new $parts[0]();

        return call_user_func_array(array($controllerObj, $parts[1]), $parameters);
    }
}
