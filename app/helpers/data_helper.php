<?php
	function startsWith($needle, $haystack) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($needle, $haystack) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
		// Negative length starts from the end of the string
	}
