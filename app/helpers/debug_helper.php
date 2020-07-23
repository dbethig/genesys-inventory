<?php
function printAndDie($array, $name = '') {
	printArray($array, $name);
	die();
}

function printArray($array, $name = '') {
	echo $name === '' ? '' : "<h3>$name</h3>";
	echo "<pre>";
	print_r($array);
	echo "</pre><hr>";
}

function printAndPause($array, $name = '') {
	printArray($array, $name);
	echo "Are you sure you want to do this?  Type 'yes' to continue: ";
	$handle = fopen ("php://stdin","r");
	$line = fgets($handle);
	if (trim($line) != 'yes'){
	  echo "ABORTING!\n";
	  exit;
	}
	fclose($handle);
	echo "\n";
	echo "Thank you, continuing...\n";
}
