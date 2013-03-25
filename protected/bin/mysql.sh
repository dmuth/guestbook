#!/bin/bash
#
# Our script to access our running copy of MySQL.
#
# Ideally, I'd write some PHP code that grabs the database 
# credentials, cobbles together a command line, and executes it.
#
# The way this script is done, we have our credentials in two places. Not so good.
#
# This is a terrible idea and I'm a terrible person for doing this. :-P
#
#


USER="guestbook"
PASSWORD="Iewypj2Ck2jY"
HOST="localhost"
DATABASE="guestbook"


mysql -u ${USER} -p${PASSWORD} -h ${HOST} ${DATABASE}


