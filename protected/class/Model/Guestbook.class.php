<?php
/**
* Our Model_Guestbook class.  It is responsible for writing to (and reading from) our Guestbook.
*
*/

class Model_Guestbook {

	//
	// Our database object
	//
	private $db;

	//
	// Our flickr object
	//
	private $flickr;


	/**
	* Our construcotr.
	* 
	* @param object $db Our database object.
	*
	* @param object $flickr Our Flickr object
	*
	* @return null
	*/	
	function __construct($db, $flickr) {

		$this->db = $db;
		$this->flickr = $flickr;

	} // End of __construct()


	/**
	* Check to see if our data is sane.
	*
	* @param array $data Our array of data that we'd like to insert.
	*
	* @return array If there are any issues, an array of 
	*	human-readable errors are returned.
	*/
	function validate($data) {

		$retval = array();

		if (empty($data["name"])) {
			$retval[] = "You need to provide a name!";
		}

		if (empty($data["message"])) {
			$retval[] = "You need to enter a message!";
		}

		if (empty($data["tags"])) {
			$retval[] = "You need to specify tags";
		}

		return($retval);

	} // End of validate()


	/**
	* Our function to save a new Guestbook entry.
	*
	* @param array $data Our array of data to enter.
	*
	* @return array If there are any issues with our data, this will 
	*	be an array of human-readable errors.
	*
	* @throws An exception if there are any issues with the database
	*/
	function save($data) {
		
		$retval = $this->validate($data);
		if (count($retval)) {
			return($retval);
		}
		
		//
		// First step, get thumbnails for our interests
		//
		$tags = explode(",", $data["tags"]);
		foreach ($tags as $key => $value) {
			$tags[$key] = ltrim(rtrim($value));
		}

		$thumbnails = array();
		foreach ($tags as $key => $value) {
			$thumbnail = $this->flickr->searchMostRecentThumb($value);
			$thumbnails[] = $thumbnail;
		}

		//
		// Now save our user.
		//
		$user_id = $this->saveUser($data);

		//
		// ...and the user tags.
		//
		$this->saveInterests($user_id, $tags, $thumbnails);

		return($retval);

	} // End of save()


	/**
	* Fetch recent Guestbook entries.
	*
	* @param integer $limit The maximum number of entries to fetch.
	*
	* @return array An array of our recent Guestbook entries.
	*
	* @throws An exception if there are any issues with the database.
	*/
	function fetch($limit = 10) {

		$retval = array();

		//
		// Escaping numbers for LIMIT never works. Ever.
		// So let's just turn this into an actual integer.
		//
		$limit = intval($limit);

		//
		// Grab our users fist.
		//
		$query = "SELECT * "
			. "FROM guestbook_users AS users "
			. "ORDER BY id DESC "
			. "LIMIT $limit "
			;

		$this->db->query($query);
		while ($row = $this->db->fetch()) {
			$user_id = $row["id"];
			$row["interests"] = array();
			$retval[$user_id] = $row;
		}

		//
		// No users found? Stop here.
		//
		if (!count($retval)) {
			return($retval);
		}

		//
		// Now grab our interests for those user_ids
		// This is probably saner that a table join, 
		// especially once we get past 1 million rows.
		//
		$user_ids = array_keys($retval);
		$user_ids_string = join(", ", $user_ids);

		$query = "SELECT * FROM guestbook_interests "
			. "WHERE "
			. "user_id in (${user_ids_string}) "
			;
		$this->db->query($query);

		while ($row = $this->db->fetch()) {
			$user_id = $row["user_id"];
			$retval[$user_id]["interests"][] = $row;
		}

		return($retval);

	} // End of fetch()


	/**
	* Save our user to the database.
	*
	* @param array $data Our array of user data
	*
	* @return integer The id from the user table.
	*/ 
	private function saveUser($data) {

		$retval = "";

		$query = "INSERT INTO guestbook_users "
			. "(name, message, ip, created) "
			. "VALUES (?, ?, ?, UNIX_TIMESTAMP()) "
			;
		$args = array($data["name"], $data["message"], $_SERVER["REMOTE_ADDR"]);
		$result = $this->db->query($query, $args);

		$retval = $this->db->getLastInsertId();

		return($retval);

	} // End of saveUser()


	/**
	* Save a user's interests.
	*
	* @param integer $user_id The user_id
	*
	* @param array $tags An array of tags from that user.
	*
	* @param array $thumbnails An array of URLs of thumbnail images that match the interests.
	*/
	private function saveInterests($user_id, $tags, $thumbnails) {

		$query = "INSERT INTO guestbook_interests "
			. "(user_id, interest, picture_url) "
			. "VALUES (?, ?, ?) "
			;

		foreach ($tags as $key => $value) {

			$tag = $value;
			$url = $thumbnails[$key];
			$args = array($user_id, $tag, $url);

			$this->db->query($query, $args);

		}

	} // End of SaveInterests()


} // End of Model_Guestbook


