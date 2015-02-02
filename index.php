<?php

include( "core/errors.php" );
include( "core/input.php" );
include( "core/request.php" );
include( "core/response.php" );
include( "core/controller.php" );
include( "core/router.php" );

Router::get('', 'home@index');

// Router::post('', 'home@index');

Router::error('error@index');

Router::dispatch();
