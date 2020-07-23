<?php

class PageError extends Controller {

	public function index() {

		// Index is the default method when none are passed
		$data = [];

		$this->view('error/index', $data, '404 Page Not Found');
	}
}
