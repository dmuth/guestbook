<?php
/**
* Just a test script for testing out different parts of my system.
*
* Unit tests would be nice, but probably overkill for this project.
*
* Ideally, I'd also have code here that keeps any of this from 
* running on production, but I need a system to determine that, first.
*
*/


//
// Bring in our autoloader
//
require_once("./protected/autoload.inc.php");


/**
* Our main test function.
* 
* @return null
*/
function test_main() {

	//test_classloader();
	//test_factory();
	//test_config();
	//test_db();
	//test_curl();
	//test_flickr();
	//test_model_guestbook();
	//test_controller_guestbook();

} // End of test_main()


/**
* Test out our classloader.
*
* @return null
*/
function test_classloader() {

	$object1 = new Sample();
	$object2 = new Sample_Sample2();

} // End of test_classloader()


/**
* Test out our factory class.
*
* @return null
*/
function test_factory() {

	$factory = new Factory();
	$object1 = $factory->getObject("Sample");
	$object2 = $factory->getObject("Sample_Sample2");

	//
	// This will break
	//
	$object3 = $factory->getObject("foobar");

} // End of test_factory()


/**
* Test out our configuration class
*
* @return null
*/
function test_config() {

	$factory = new Factory();

	$config = $factory->getObject("Config");
	$bucket = "test";
	$key = "foo";

	print "$bucket: $key: " . $config->get($bucket, $key) . "<br/>\n";

	$key = "bar";
	print "$bucket: $key: " . $config->get($bucket, $key) . "<br/>\n";

	print_r($config->getBuckets());

} // End of test_config()


/**
* Test out our database class.
*
* @return null
*/
function test_db() {

	$factory = new Factory();
	$db = $factory->getObject("Db");

	$db->query("DROP TABLE IF EXISTS test");

	$db->query("CREATE TABLE test "
		. "("
		. "id INTEGER PRIMARY KEY AUTO_INCREMENT, "
		. "data VARCHAR(32) "
		. ") "
		);

	$query = "INSERT INTO test (data) VALUES (?) ";
	$db->query($query, array("foo"));
	$db->query($query, array("bar"));

	$results = $db->getLastInsertId();
	print "Last inserted Id: " . print_r($results, true) . "</br>\n";

	$db->query("SELECT * FROM test ");
	$results = $db->fetchAll();
	print "<pre>"; print_r($results); print "</pre>";

	$db->query("SELECT * FROM test ");
	$results = $db->fetch();
	print "<pre>"; print_r($results); print "</pre>";
	$results = $db->fetch();
	print "<pre>"; print_r($results); print "</pre>";
	$results = $db->fetch();
	print "<pre>"; print_r($results); print "</pre>";

	//
	// Test with a bad table
	//
	$db->query("SELECT * FROM foobar ");
	$results = $db->fetchAll();
	print "<pre>"; print_r($results); print "</pre>";


} // End of test_db()


/**
* Test our curl class.
*
* @return null
*/
function test_curl() {

	$factory = new Factory();
	$curl = $factory->getObject("Curl");

	$url = "http://www.google.com/";
	print "$url<br/>\n";
	$results = $curl->get($url);
	print "<pre>"; print_r(array_keys($results)); print "</pre>";
	unset($results["data"]);
	print "<pre>"; print_r($results); print "</pre>";

	$url = "http://www.google.com/notaurl";
	print "$url<br/>\n";
	$results = $curl->get($url);
	print "<pre>"; print_r(array_keys($results)); print "</pre>";
	unset($results["data"]);
	unset($results["error"]);
	print "<pre>"; print_r($results); print "</pre>";

	$url = "http://localhost:1234/";
	print "$url<br/>\n";
	$results = $curl->get($url);
	print "<pre>"; print_r(array_keys($results)); print "</pre>";
	unset($results["data"]);
	print "<pre>"; print_r($results); print "</pre>";

	$url = "http://foobar.localdomain/";
	print "$url<br/>\n";
	$results = $curl->get($url);
	print "<pre>"; print_r(array_keys($results)); print "</pre>";
	unset($results["data"]);
	print "<pre>"; print_r($results); print "</pre>";

} // End of test_curl()


/**
* Test out our Flickr object.
*
* @return null
*/
function test_flickr() {

	$factory = new Factory();
	$flickr = $factory->getObject("Api_Flickr");

	$results = $flickr->searchMostRecentThumb("cats");
	print "<pre>"; print_r($results); print "</pre>";
	print "<img src=\"$results\" /><br/>\n";

	$results = $flickr->searchMostRecent("cats");
	print "<pre>"; print_r($results); print "</pre>";

} // End of test_flickr()


/**
* Test out our Model_guestbook class
*/
function test_model_guestbook() {

	$factory = new Factory();
	$guestbook = $factory->getObject("Model_Guestbook");

	$data = array();
	$results = $guestbook->validate($data);
	print "<pre>"; print_r($results); print "</pre>";

	$data["name"] = "Douglas Muth";
	$data["message"] = "Socially awkward penguin.";
/*
	$results = $guestbook->save($data);
	print "<pre>"; print_r($results); print "</pre>";
*/

	$data["tags"] = "cats, cheetahs, leopards";
	$results = $guestbook->save($data);
	print "<pre>"; print_r($results); print "</pre>";

	$results = $guestbook->fetch(3);
	print "<pre>"; print_r($results); print "</pre>";

} // End of test_model_guestbook()


/**
* Test our Controller_Guestbook class
*/
function test_controller_guestbook() {

	$factory = new Factory();
	$guestbook = $factory->getObject("Controller_Guestbook");

	$_POST = array();
	$results = $guestbook->go(2);
	print "<pre>"; print_r($results); print "</pre>";
	
	$_POST["beenhere"] = true;
	$results = $guestbook->go(2);
	print "<pre>"; print_r($results); print "</pre>";

	$_POST["name"] = "Douglas Muth";
	$_POST["message"] = "Just stopping by";
	$_POST["tags"] = "cats, dogs";
	$results = $guestbook->go(3);
	print "<pre>"; print_r($results); print "</pre>";

} // End of test_controller_guestbook()


try {
	test_main();

} catch (Exception $e) {
	print "<pre>"
		. $e->getMessage()
		. "\n\n"
		. print_r($e->getTrace(), true)
		. "</pre>\n"
		;

}



