#! /bin/bash
# A modification of Dean Clatworthy's deploy script as found here: https://github.com/deanc/wordpress-plugin-git-svn
# The difference is that this script lives in the plugin's git repo & doesn't require an existing SVN repo.
 
#Instructions
# Update 'NEWVERSION1' with correct version number
#1. Open up command line utility
#2. cd into the directory that this script is located in
#3. deploy this script 
# ./deploy.sh
#3. Enter github password twice and magic happens
 
# main config
PLUGINSLUG="cta"
CURRENTDIR=`pwd`
MAINFILE="calls-to-action.php" # this should be the name of your main php file in the wordpress plugin
 
# git config
GITPATH="$CURRENTDIR" # this file should be in the base of your git repository
TEMPPATH="$GITPATH/tmp" # this should be the name of your main php file in the wordpress plugin
 
# svn config
SVNPATH="$TEMPPATH/$PLUGINSLUG" # path to a temp SVN repo. No trailing slash required and don't add trunk.
SVNURL="http://plugins.svn.wordpress.org/cta/" # Remote SVN repo on wordpress.org, with no trailing slash

 
# Let's begin...
echo ".........................................."
echo
echo "Preparing to deploy wordpress pluginzz"
echo
echo ".........................................."
echo
 
# Check version in readme.txt is the same as plugin file after translating both to unix line breaks to work around grep's failure to identify mac line breaks
NEWVERSION1=`grep "^Stable tag" $GITPATH/readme.txt | awk '{ print $NF}'`
echo "readme.txt version: $NEWVERSION1"
NEWVERSION2=`grep "^Version:" $GITPATH/$MAINFILE | awk -F' ' '{print $NF}'`
echo "$MAINFILE version: $NEWVERSION2"
 
if [ "$NEWVERSION2" != "$NEWVERSION2" ]; then 
	echo "Version in readme.txt & $MAINFILE don't match. Exiting...."; 
	sleep 20 
	exit 1; 
fi
 
echo "Versions match in readme.txt and $MAINFILE. Let's proceed..."
 
if git show-ref --tags --quiet --verify -- "refs/tags/$NEWVERSION1"
    then
        echo "Version $NEWVERSION1 already exists as git tag. Exiting....";
		sleep 20
        exit 1;
    else
        echo "Git Tag for this version does not exist. Let's proceed..."
fi
 
#cd $GITPATH
echo -e "Enter a commit message for this new version: \c"
read COMMITMSG
git commit -am "$COMMITMSG"
sleep 5

echo "Tagging new version in git"
git tag -a "$NEWVERSION1" -m "Tagging version $NEWVERSION1"
sleep 5

# Push to Origin
if git remote | grep origin > /dev/null; then
	echo "Pushing latest commit to origin 'origin', with tags"
	git push origin master
	git push origin master --tags
fi

#Push to Github
if git remote | grep github > /dev/null; then
	echo "Pushing latest commit to origin 'github', with tags"
	git push github master
	git push github master --tags
fi

 
echo "Removing temporary directory $TEMPPATH"
rm -fr $TEMPPATH
sleep 5

echo "Creating local copy of SVN repo ..."
svn co $SVNURL $SVNPATH
sleep 5

echo 'Change directories into svn repo'
cd $SVNPATH

echo 'deleting contents of trunk'
svn rm trunk
sleep 5

echo "Exporting the HEAD of master from git to the trunk of SVN"
cd $GITPATH
git checkout-index -a -f --prefix=$SVNPATH/trunk/
sleep 5


echo "Adding trunk files to sv"
cd $SVNPATH
svn add trunk
sleep 5


echo "Updating ignore file"
cd $SVNPATH
svn propset svn:ignore -F $GITPATH/.gitignore  "$SVNPATH/trunk/"

echo "Ignoring additional files"
svn propset svn:ignore "deploy.sh
README.md
composer.json
*.phar
codeception.yml
.travis.yml
Gruntfile.js
.git
.gitignore" "$SVNPATH/trunk/"
sleep 10

echo "Creating new SVN tag"
svn copy trunk/ tags/$NEWVERSION1/
sleep 10

echo "Commiting changes to SVN"
ls
svn commit  -m "Tagging version $NEWVERSION1" --no-auth-cache --force-log
sleep 10

echo "Removing temporary directory $SVNPATH"
cd $GITPATH
rm -fr $TEMPPATH
echo "*** FIN ***"
sleep 9999