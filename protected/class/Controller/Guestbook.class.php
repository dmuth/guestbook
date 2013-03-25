<?php
/**
* This is our controller class for displaying the guestbook, 
* and handling form submissions.
*/


class Controller_Guestbook {


	//
	// Our Guestbook model class
	//
	private $model;

	//
	// Our view object
	//
	private $view;


	/**
	* Our constructor.
	*
	* @param object $model Our guestbook model
	*
	* @param object $view Our view object.
	*/
	function __construct($model, $view) {

		$this->model = $model;
		$this->view = $view;

	} // End of __construct()


	/** 
	* This is it!  The main entry point that handles displaying our form, 
	* our Guestbook, and does form processing, if necessary.
	*
	* @param integer $num How many recent guestbook entries do we want 
	*	to display?
	*
	* @return string HTML code that can be sent off to the browser.
	*/
	function go($num = 10) {

		$retval = "";

		//
		// Data to send off to the view
		//
		$data = array();

		if (isset($_POST["beenhere"])) {

			$results = $this->model->save($_POST);
			if (count($results)) {
				$data["errors"] = $results;

			} else {
				//
				// The form was submitted successfully, redirect the user.
				// We're redirecting because we don't want the user to reload 
				// the page and submit the same entry again.
				//
				$this->redirect();

			}

		}

		$data["data"] = $this->model->fetch($num);

		$retval = $this->view->render("guestbook", $data);

		return($retval);

	} // End of go()


	/**
	* Actual function to redirect the user's browser.
	*
	* @return null Under normal circumstances, this 
	*	function won't return at all, because exit() will be called.
	*/
	function redirect() {

			//
			// In the real world, I would compute this with a wrapper 
			// to REQUEST_URI or similar.
			//
			// Also note that reidrecting to a URI instead of a URL is 
			// a VIOLATION of the HTTP RFC. I'm surprised that most 
			// browsers handle it, though.
			//
			$target = "/index.php";
			if (!headers_sent()) {
				$header = "Location: $target\r\n";
				header($header);
				exit();
			}

			//
			// I would never do this in the real world, either.
			//
			print "Oops. Looks like our headers were already sent. "
				. "Can't redirect to '$target'. Oh well.<br/>\n";

			return(null);

	} // End of redirect()



} // End of Controller_Guestbook



