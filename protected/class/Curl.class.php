<?php
/**
* This class is a wrapper for the Curl functionality in PHP.
* 
* The reason why I wrote it is because curl has a stupid number 
* of options and settings, and I don't want to mess with them 
* at the application level.  I want one function I can call, 
* and be done with it.
*/
class Curl {


	/**
	* Our constructor. It does nothing!
	*
	* @return null
	*/
	function __construct() {
	}


	/**
	* Fetch data from a specific URL
	*
	* @param string $url The URL
	*
	* @return array This is an array with multiple elements
	*	ok: boolean.  Did the request complete with a 2xx code?
	*	error: string.  Contains the error, if there is one.
	*	status: string.  Our NNN HTTP status code.  Usually.  
	*		It will be zero if a conneciton is refused or the 
	*		hostname does not resolve.
	*	data: string.	Whatever data we got back from the remote host.
	*/
	function get($url) {

		$retval = array();

		//
		// Set a timeout so we don't hang around forever.
		//
		$timeout = 5;
		//$timeout = 1; // Debugging

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		$result = curl_exec($ch);

		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$status = strval($status);
		$retval["status"] = $status;

		if ($status[0] == "2") {
			$retval["ok"] = true;
			$retval["data"] = $result;

		} else if ($status == "0") {
			$retval["ok"] = false;
			$retval["error"] = 
				"We received status code 0. Either the DNS lookup "
				. "failed or the connection was refused. Either way, "
				. "an HTTP connection was never established."
				;

		} else {
			$retval["ok"] = false;
			$retval["error"] = $result;

		}

		curl_close($ch);

		return($retval);

	} // End of get()


} // End of Curl class

