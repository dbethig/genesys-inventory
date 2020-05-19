<?php

// Simple page redirect
function url_redirect($page) {
	header('Location: ' . URLROOT . '/' . $page);
}
