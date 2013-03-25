#!/bin/bash
#
# Make a zipfile for distribution.
# I don't want to put this code on GitHub, and I 
# don't have a private git server handy, so Zipfiles it is!
#

#
# Errors are fatal
#
set -e
set -x # Debugging

#
# Switch to the directory of this file
#
DIR=`dirname $0`
pushd $DIR > /dev/null

#
# Now get our root directory for this project, then go back
# to our original directory.
#
cd ../..
SRC_DIR=`pwd`

#
# If this file is hanging out from before, remove it.
#
ZIPFILE="dist.zip"
rm ${ZIPFILE} || true

zip ${ZIPFILE} -r * .htaccess .git

echo "Distfile created as `pwd`/${ZIPFILE}"


