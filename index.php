<?php
/**
* Our main entry point for the app.
*/


//
// Bring in our autoloader
//
require_once("./protected/autoload.inc.php");

//
// Create our guestbook controller
//
$factory = new Factory();
$controller = $factory->getObject("Controller_Guestbook");

$num = 10;
$html = $controller->go($num);
print $html;

