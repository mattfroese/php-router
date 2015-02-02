<?php

class Input {
  public static function get( $name ) {
    return isset( $_GET[ $name ] ) ? $_GET[ $name ] : null;
  }
  public static function post( $name ) {
    return isset( $_POST[ $name ] ) ? $_POST[ $name ] : null;
  }
}
