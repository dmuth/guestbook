<?php
/**
* Our database wrapper.  It uses PDO.
*/

class Db {

	//
	// Our instance of $config
	//
	private $config;

	//
	// Our database connection
	//
	private $conn;

	//
	// Our cursor for a specific query
	//
	private $cursor;


	/**
	* @param object $config Our instance of the Configure class.
	*
	* @return null
	*/
	function __construct($config) {

		$this->config = $config;

	} // End of __construct()


	/**
	* Our query function.
	*
	* @param string $query Our query to send to MySQL
	*
	* @param array $args An optional array of arguments to pass into MySQL.
	*	Do not--I repeat--NOT attempt to sanitize the MySQL input data 
	*	yourself. Down that path lies madness and security incidents.
	*
	* @return array An array of results, if the query was a SELECT statement.
	*
	*/
	function query($query, $args = "") {

		$retval = array();

		if (!isset($this->conn)) {
			$this->connect();
		}

		//
		// Have some arguments?  Prepare the query first. Otherwise, just execute it.
		if (is_array($args) && count($args)) {
			$this->cursor = $this->conn->prepare($query);
			$this->cursor = $this->cursor->execute($args);

		} else {
			$this->cursor = $this->conn->query($query);

		}

		//
		// It's unlikely we'll make it here, since exceptions are 
		// thrown now. But if they are, we'll catch it.
		//
		if ($this->conn->errorCode() != 0) {
			$error = "MySQL error on query '$query': " 
				. print_r($this->conn->errorInfo(), true);
			throw new Exception($error);
		}

		return($retval);

	} // End of query()


	/**
	* Fetch a single row form the current cursor. 
	* Call this multiple times to get all rows.
	*
	* @return array An assosciative array with 1 row, or an empty 
	*	array when we're done with the result set.
	*/
	function fetch() {

		$retval = array();

		if ($line = $this->cursor->fetch(PDO::FETCH_ASSOC)) {
			$retval = $line;
		}

		return($retval);

	} // End of fetch()


	/**
	* Fetch all of the rows from the current cursor.
	*
	* @return array An array of all of our rows
	*/
	function fetchAll() {

		$retval = $this->cursor->fetchAll(PDO::FETCH_ASSOC);

		return($retval);

	} // End of fetchAll()


	/**
	* Get the auto_incremented ID that was created in the previous insert.
	*
	* @return mixed An integer if we just inserted a new row. Empty otherwise.
	*/
	function getLastInsertId() {

		$retval = $this->conn->lastInsertId();

		return($retval);

	} // End of getLastInsertId()


	/**
	* Actually connect to our MySQL server.
	*
	* @throws An exception if we failed to connect for some reason.
	*
	*/
	private function connect() {

		$db = $this->config->get("db", "database");
		$host = $this->config->get("db", "host");

		$dsn = "mysql:dbname=${db};host=${host}";
		$user = $this->config->get("db", "user");
		//$user = "nosuchuser"; // Debugging
		$password = $this->config->get("db", "password");

    	$this->conn = new PDO($dsn, $user, $password);
		//
		// We want any database error to throw an exception.
		//
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} // End of connect()


} // End of Db class


