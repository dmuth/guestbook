<?php
/**
* This class is used to load templates for viewing.
*/

class View {


	/**
	* Our constructor. It does nothing.
	*/
	function __construct() {
	} // End of __construct()


	/** 
	* This function loads a template, renders it, and returns the result.
	*
	* @param string $filename The basename of the template we want to load.
	*
	* @param array $data An array of data to pass into the template.
	*
	* @return string An HTML document that we can send off to the browser.
	*
	* @throws An exception if the template is not found.
	*/
	function render($filename, $data) {

		$retval = "";

		$path = __DIR__ . "/../views/${filename}.php";

		if (!is_file($path)) {
			$error = "The template '${path}' does not exist!";
			throw new Exception($error);
		}

		if (!is_readable($path)) {
			$error = "The template '${path}' is not readable!";
			throw new Exception($error);
		}

		//
		// Load our content
		//
		$content = file_get_contents($path);

		//
		// Okay, here's what's going on.  We want to run the content 
		// as PHP code.  We can't just include() it, because then we 
		// need to have data generated and a return() called, which 
		// makes it harder for designers to mess with that code.
		//
		// Instead, we're going to unescape from PHP, turn on buffering,
		// eval the code, grab the buffer's contents, and return them.
		//
		$content = "?>". $content;
		ob_start();

		eval($content);
		$retval = ob_get_contents();

		ob_end_clean();

		return($retval);

	} // End of render()


} // End of View class

