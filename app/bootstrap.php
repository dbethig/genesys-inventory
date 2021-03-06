<?php
// Load config
require_once 'config/config.php';
// Load Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/data_helper.php';
require_once 'helpers/setting_helper.php';
require_once 'helpers/debug_helper.php';

// Autoload Core Libraries
spl_autoload_register(function($className){
	require_once 'libs/' . $className . '.php';
});
