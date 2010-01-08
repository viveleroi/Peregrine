#!/bin/sh

# THIS SCRIPT WAS DESIGNED TO PREPARE PEREGRINE FOR A PRODUCTION RELEASE

if [ $# -ne 3 ]; then
     echo 1>&2 Usage: 1.0 rc1 Release_Candidate
     exit 0
fi

if [ $2 = "final" ]; then
     versname=$1
else 
     versname=$1$2
fi

# remove any existing exports
rm -rf Peregrine

# checkout the latest code from trunk
git clone git://github.com/botskonet/Peregrine.git
cd Peregrine

# checkout the proper branch
git checkout --track -b $1$2 origin/$1$2

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
mv p-temp.tar.gz ../Peregrine-$versname.tar.gz
cd ..
rm -rf latest
mv Peregrine latest

echo "RELEASE COMPLETE"