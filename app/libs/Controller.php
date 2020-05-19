<?php
/*
	* Base Controller
	* Loads the models and views
*/

class Controller {
	// Load model
	public function model($model) {
		// Require model file
		require_once '../app/models/' . $model . '.php';

		// Instantiate model
		return new $model();
	}

	// Load view
	public function view($view, $data = [], $pageName ='Genesys Helper') {
		// Set template filename
		$template = 'default';
		// Check for template folder
		if (file_exists('../app/views/themes/' . $template)) {
			include '../app/views/themes/' . $template . '/header.php';

			// Check for view file
			if (file_exists('../app/views/' . $view . '.php')) {
				// Load view file
				require_once '../app/views/' . $view . '.php';
			}

			include '../app/views/themes/' . $template . '/footer.php';
		} else {
			die('Theme not found!');
		}
	}
}
