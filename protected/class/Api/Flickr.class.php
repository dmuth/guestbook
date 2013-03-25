<?php
/**
* This class is for querying Flickr's API.
*/

class Api_Flickr {

	//
	// Our instance of Curl.
	//
	private $curl;


	/**
	* Our constructor.
	*
	* @param object $curl Our instance of Curl.
	*
	* @return null
	*/
	function __construct($curl) {

		$this->curl = $curl;

	} // End of __construct()


	/**
	* Search Flickr's public API for a specific tag.
	*
	* @param string $tag The tag to search for
	*
	* @return array An array of the first photo data we find.
	*/
	function searchMostRecent($tag) {

		$retval = array();

		$url = "http://api.flickr.com/services/feeds/photos_public.gne?"
			. "tags=" . rawurlencode($tag)
			//. "&format=json" // Uh, no.  I hate JSONP.
			. "&format=php_serial"
			;
		$data = $this->curl->get($url);

		//
		// If something went wrong, bail out here.
		//
		if (!$data["ok"]) {
			return($retval);
		}

		$data = unserialize($data["data"]);

		$retval = $data["items"][0];

		return($retval);

	} // End of searchMostRecent()


	/**
	* Search for the most recent thumbnail.
	*
	* Basically, this is a wrapper for searchMostRecent()
	*
	* @param string $tag The tag to search for
	*
	* @return string A URL of a thumbnail, or an empty string if 
	*	something went wrong.
	*/
	function searchMostRecentThumb($tag) {

		$retval = "";

		$data = $this->searchMostRecent($tag);
		if ($data["t_url"]) {
			$retval = $data["t_url"];
		}

		return($retval);

	} // End of searchMostRecent()


} // End of Api_Flickr class


