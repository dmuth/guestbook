--
-- Our SQL to create the tables for this project.
--

DROP TABLE IF EXISTS guestbook_users;
DROP TABLE IF EXISTS guestbook_interests;


CREATE TABLE guestbook_users (

	id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,

	--
	-- The user's name
	--
	name VARCHAR(64) NOT NULL,
	
	--
	-- The message the user left.
	--
	message VARCHAR(1024) NOT NULL,

	--
	-- What IP address did the user come form?
	--
	ip VARCHAR(16) NOT NULL,

	--
	-- When did the user enter this?
	-- We store this in a time_t since it is timezone-independent.
	--
	created INTEGER UNSIGNED

);


--
-- Our user interests.
--
-- Note that this table is NOT normalized.  Third normal form is nice,
-- but once you get past 1 M rows, things like table joins, GROUP BY, 
-- and ORDER BY get difficult.
--
CREATE TABLE guestbook_interests (

	id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,

	-- 
	-- Foreign key to the user
	-- 
	user_id INTEGER UNSIGNED,

	-- 
	-- A single interest.  No comma or trailing space should be stored.
	-- 
	interest VARCHAR(16) NOT NULL,

	--
	-- The URL of the photo to display.
	--
	picture_url VARCHAR(64) NOT NULL,

	FOREIGN KEY (user_id)
		REFERENCES guestbook_users(id)

);




