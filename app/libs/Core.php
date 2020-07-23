<?php
/*
	*	App Core Class
	*	Creates URL & loads core Controller
	*	URL FORMAT = /controller/method/params
*/

class Core {
	protected $curretController = 'PageError';
	protected $currentMethod = 'index';
	protected $params = [];
	protected $pageError = true;

	public function __construct() {
		$url = $this->getURL();
		if(file_exists('../app/controllers/' . $url[0] . '.php')) {
			// if exists, set as controller
			$this->curretController = ucwords($url[0]);
			// Unset 0 index
			unset($url[0]);
			$this->pageError = false;
		} elseif (empty($url) || $url[0] == 'index') {
			$this->curretController = 'Pages';
			$this->pageError = false;
		}

		// Require the controller
		require_once '../app/controllers/' . $this->curretController . '.php';

		// Instansiate controller class
		$this->curretController = new $this->curretController;

		// Check for second part of url
		if(isset($url[1])) {
			// Check to see if method exists in controller
			if (method_exists($this->curretController, $url[1])) {
				$this->currentMethod = $url[1];
				// Unset 1 index
				unset($url[1]);
				$this->pageError = false;
			}
		}

		// Get params
		$this->params = $url ? array_values($url) : [];
		if ($this->pageError === true) {
			$this->curretController = 'PageError';
			$this->currentMethod = 'index';
			$this->params = [];
			// Require the controller
			require_once '../app/controllers/' . $this->curretController . '.php';
			// Instansiate controller class
			$this->curretController = new $this->curretController;
		}
		// Call a callback with array of params
		call_user_func_array([$this->curretController, $this->currentMethod], $this->params);
	}

	public function getUrl() {
		// the $_GET('url') is anything after the first / in the url
		if(isset($_GET['url'])) {
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = str_replace('-', '', $url);
			$url = explode('/', $url);
			return $url;
		}
	}

}
