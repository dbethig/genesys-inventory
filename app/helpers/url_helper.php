<?php

// Simple page redirect
function url_redirect($url) {
	header("Location: " . URLROOT . "/$url");
}

function errorPage($msg = null) {
	if ($msg) {
		flash('page_err', $msg, 'alert alert-danger');
	}
	header("Location: " . URLROOT . "/pageerror");
	die();
}
