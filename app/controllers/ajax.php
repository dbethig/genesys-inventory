<?php
class Ajax extends Controller {

	public function attr($type = 'General') {
		$type = str_replace('_', ' ', $type);
		$data = [
			'type' => $type
		];
		// Check for view file
		$this->view('ajax/test', $data, '', false);
	}
}
