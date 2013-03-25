<?php
/**
* A sample class, used for testing out my autoloader.
*/


class Sample_Sample2 extends Sample {


	/**
	* Our constructor.
	*
	* @return null
	*/
	function __construct() {
		parent::__construct();
		print "Inside constructor for class " . __CLASS__ . "<br/>\n";
	}


} // End of class Sample_Sample2


