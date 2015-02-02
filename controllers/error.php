<?php

class Error extends Controller {

	private $_error = null;

	public function __construct(){
		parent::__construct();
	}

	public function index($error){
		if( $this->_error == 'No routes found.' ) {
		    return Response::notFound( $error );
		} else {
			return Response::serverError( $error );
		}
	}

}
