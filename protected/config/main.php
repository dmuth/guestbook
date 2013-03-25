<?php
/**
* This file holds our configuration.
* It is meant to be loaded via include() or similar.
*
*/

$_retval = array();

//
// Test data
//
$_retval["test"] = array();
$_retval["test"]["foo"] = "foobar!";

//
// Our database credentials
//
if (!is_file(__DIR__ . "/db.php")) {
	$error = "protected/config/db.php not found. Please make that "
		. "be a symlink to the appropriate database config file."
		;
	throw new Exception($error);
}
$_retval["db"] = require("db.php");

//
// Yes, this is slightly weird.
// It is, however, the sanest method I know of that lets me split 
// configuration data into different files.
//
// That's not to say that there aren't other ways of doing this.  
// I just think this is the sanest. Your mileage may vary.
//
unset($_retval_db);

//print "<pre>"; print_r($_retval); print "</pre>"; // Debugging

return($_retval);

