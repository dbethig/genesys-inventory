<?php

class Pages extends Controller {
	public function __construct() {

	}

	public function index() {

		// Index is the default method when none are passed
		$data = [
			'title' => 'Genesys Helper',
			'description' => 'Organise and create content for Fantasy Flight\'s Genesys roleplaying system.'
		];

		$this->view('pages/index', $data);
	}
}
