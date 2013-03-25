<html>
<head>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
/**
* Our guestbook view.  This is basically a template with data passed in that we'll act on.
*/

//
// If we have any errors, display them.
//
//$data["errors"] = array("test"); // Debugging
if (isset($data["errors"])) {
	?>
	<div class="errors">
	Your form could not be submitted due to the following errors:
	<ul>
	<?php
	foreach ($data["errors"] as $key => $value) {
		$html = "<li>" . htmlentities($value) . "</li>";
		print $html;
	}
	?>
	</ul>
	</div>
	<?php
}

//
// Display our form
//
?>
<div class="guestbook-form">
Let us know you were here! Leave a message below.

<form action="index.php" method="POST" >

<?php
//
// Designers would murder me for using a table, but it's really the 
// fastest way to do this. I can always write some CSS later if I want...
//

?>
<table>

<tr>
<td align="right">Name:</td>
<td>
<input type="text" name="name" 
	value="<?php print htmlentities(
		isset($_POST["name"]) ? $_POST["name"] : "");?>" 
		/>
</td>
</tr>

<tr>
<td align="right">Interests:</td>
<td>
<input type="text" name="tags" 
	value="<?php print htmlentities(
		isset($_POST["tags"]) ? $_POST["tags"] : "");?>" 
		/>
</td>
</tr>

<tr>
<td align="right" valign="top">Messages:</td>
<td>
<textarea name="message" rows="10" cols="40" 
	><?php print htmlentities(
		isset($_POST["tags"]) ? $_POST["tags"] : "");?></textarea>
		
</td>
</tr>

<input type="hidden" name="beenhere" value="1" />

<tr>
<td></td>
<td>
<input type="submit" value="Leave your Message!" />
</td>
</tr>

</table>

</form>

</div><?php // guestbook-form ?>
<?php

//
// Now display our Guestbook entries.
//
?>
<div class="guestbook">
<?php
foreach ($data["data"] as $key => $value) {

	$id = $value["id"];
	$name = $value["name"];
	$date = date("r", $value["created"]);
	$message = $value["message"];
	$interests = $value["interests"];

	$interests_html = "";
	$interests_list = "";
	foreach ($interests as $key => $value) {
		$interest_name = $value["interest"];
		if ($interests_list) {
			$interests_list .= ", ";
		}
		$interests_list .= $interest_name;

		$url = $value["picture_url"];
		$interests_html .= "<div class=\"interest\">"
			. "<img src=\"${url}\" title=\"" 
				. htmlentities($interest_name) . "\" />"
			. "</div>"
			;
	}

	?>
	<div class="entry" />
	<div class="guestbook_line name">Name: <?php print htmlentities($name); ?>
	<div class="entry_id">(Entry Id #: <?php print $id; ?>)</div>
	</div>
	<div class="guestbook_line date">Date: <?php print $date; ?></div>
	<div class="guestbook_line interests">Things I like: <?php print $interests_list; ?>
		<div class="interest_list"><?php print $interests_html; ?></div>
		</div>
	<br clear="all" />
	<div class="guestbook_line message">Message: <?php print htmlentities($message); ?></div>
	</div>

	<hr>

	<?php
}
?>
</div><?php // guestbook ?>

<?php
//print "<pre>"; print_r($data); // Debugging
?>

</body>
</html>

