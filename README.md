
# Guestbook App

This is a sample guestbook app that I wrote in PHP, using a custom MVC 
framework that I built just for this project.

It does the following:

- Prompts a user to enter their name
- Prompts a user to enter their interests in comma-delimited form
- Prompts a user to enter their message

Once a message is saved, viewing the guestbook will cause a connection 
to be made to Flickr's API to fetch a picture for each interest entered.

## Installation

- Go into protected/config/
   - Season `db-dev.php` and `db-production.php` to taste.
   - Symlink one of those files to db.php, depending on whether 
		you are in development or production.

## Notes

- If you are running Apache, an `.htaccess` file in protected/ 
	will properly restrict access to that directory
   - If you are running another webserver, **you are repsonsible 
	for securing that directory**.

## Licensing

If you actually want to use my code, then consider it available 
under the GPL v2.

Enjoy!





