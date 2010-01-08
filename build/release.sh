#!/bin/sh

# THIS SCRIPT WAS DESIGNED TO PREPARE PEREGRINE FOR A PRODUCTION RELEASE

if [ $# -lt 1 ]; then
     echo 1>&2 Usage: 1.0 final, or head
     exit 0
fi

# remove any existing exports
rm -rf Peregrine

# checkout the latest code from trunk
git clone git://github.com/botskonet/Peregrine.git
cd Peregrine

# checkout the proper branch
if [ $1 != "head" ]; then
	git checkout --track -b $1$2 origin/$1$2
fi

# get the git revision number 
gitvers=`git describe`

# add in revision to app.default.config.php
sed -e "s/Git-Version/$gitvers/g" Peregrine.php > p-new.php
mv p-new.php Peregrine.php

#remove support dirs
rm -rf build

# remove all .git directories
rm -rf .git
rm -f .gitignore
rm -f .DS_Store

# comment this out if pushing a true release
# exit 0

# make tarball
tar czvf p-temp.tar.gz *
mv p-temp.tar.gz ../Peregrine-$gitvers.tar.gz
cd ..
rm -rf latest
mv Peregrine latest

echo "RELEASE COMPLETE"