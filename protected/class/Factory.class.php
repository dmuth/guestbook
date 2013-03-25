<?php
/**
* Our factory class for instantiating other classes in a sane 
* (and dependency injected) manner.
*/


class Factory {

	/**
	* Our constructor.  It does nothing!
	*
	* @return null
	*/
	function __construct() {
	}


	/**
	* Instantiate our object and return it.
	*
	* @param string $class The name of the class we want
	*
	* @return object The instantiated object
	*/
	function getObject($class) {

		$retval = null;

		if ($class == "Api_Flickr") {
			$curl = $this->getObject("Curl");
			$retval = new Api_Flickr($curl);

		} else if ($class == "Controller_Guestbook") {
			$model = $this->getObject("Model_Guestbook");
			$view = $this->getObject("View");
			$retval = new Controller_Guestbook($model, $view);

		} else if ($class == "Curl") {
			$retval = new Curl();

		} else if ($class == "Config") {
			$retval = new Config();

		} else if ($class == "Db") {
			$config = $this->getObject("Config");
			$retval = new Db($config);

		} else if ($class == "Model_Guestbook") {
			$db = $this->getObject("Db");
			$flickr = $this->getObject("Api_Flickr");
			$retval = new Model_Guestbook($db, $flickr);

		} else if ($class == "Sample") {
			$retval = new Sample();

		} else if ($class == "Sample_Sample2") {
			$retval = new Sample_Sample2();

		} else if ($class == "View") {
			$retval = new View();

		} else {
			$error = "Sorry, but the Factory doesn't know about class '$class'!";
			throw new Exception($error);

		}

		return($retval);

	} // End of getObject()


} // End of Factory class


