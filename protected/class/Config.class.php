<?php
/**
* Our configuration class
*/

class Config {


	/**
	* Our array of configuration data.
	*/
	private $data = array();

	/**
	* Read our configuration file.
	*
	* @throws An exception if the configuration file is not readable.
	*/
	function __construct() {

		$dir = __DIR__;
		$file = $dir . "/../config/main.php";

		if (!is_file($file)) {
			$error = "File '$file' does not exist!";
			throw new Exception($error);
		}

		if (!is_readable($file)) {
			$error = "File '$file' is not readable!";
			throw new Exception($error);
		}

		$this->data = require_once($file);

	} // End of __construct()


	/**
	* Retrieve a configuration value.
	*
	* @param string $bucket The name of the bucket to fetch from
	*
	* @param string $key The naem of the key to fetch from that bucket.
	*
	* @return mixed The value of that key, if it exists. Otherwise, null.
	*/
	function get($bucket, $key) {

		$retval = null;

		if (!isset($this->data[$bucket])) {
			return($retval);
		}

		if (!isset($this->data[$bucket][$key])) {
			return($retval);
		}

		$retval = $this->data[$bucket][$key];

		return($retval);

	} // End of get()


	/**
	* Get a list of all of our buckets.
	*
	* @return array A list of all buckets that we know about.
	*	This will be an associative array where both the key and the 
	*	value are the name of the bucket.  I got into the habit of 
	*	using this data structure instead of just scalar arrays so 
	*	that I can more easily do a lookup to determine if a specific
	*	bucket exists.
	*/
	function getBuckets() {

		$retval = array();

		foreach ($this->data as $key => $value) {
			$retval[$key] = $key;
		}

		return($retval);

	} // End of getBuckets()


} // End of Config class

