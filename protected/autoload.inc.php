<?php
/**
* Our autoloader function.A
* 
* @return null
*/

function guestbook_autoload($class) {

	$target_dir = __DIR__ . "/class";
	$filename = preg_replace("/_/", "/", $class) . ".class.php";
	$file = $target_dir . "/" . $filename;

	//print "Class: $class<br/>\n"; // Debugging
	//print "Filename: $filename<br/>\n"; // Debugging
	//print "File: $file<br/>\n"; // Debugging

	require_once($file);

} // End of guestbook_autoload()


//
// We're putting this on the end to register the autoloader.
// It's not very elegent, but since I'm not using an actual 
// framework, this seems to be the most sensible place to put 
// this for now, so that merely include()ing this file causes 
// the autoloader to be set.
//
spl_autoload_register("guestbook_autoload");


