<?php
class CustomException extends Exception {

	public function __construct() {
		// $this->controller = new Controller;
	}

	public function pageError($msg = '404 Page Not Found!') {
		// Require the controller
		require_once '../app/controllers/PageError.php';

		// Instansiate controller class
		$this->curretController = new PageError;
		// Call a callback with array of params
		call_user_func_array([$this->curretController, 'index'], []);
	}

	public function errorMessage() {
		//error message
		$errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
		.': <b>'.$this->getMessage();
		return $errorMsg;
	}
}
