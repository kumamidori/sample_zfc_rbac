#!/bin/bash
#############################################################
# Usage:
#  project=hoge.ex.co.jp # => REPLACE HERE!
#  mkdir -p ~/ex/$project
#  cd ~/ex/$project
#  wget "https://gist.github.com/yuki777/5185456/raw/aa4bbae9c00bf0fdade286b8f189feafe96f4f56/make.bash"  --no-check-certificate
#  /bin/bash ./make.bash $project | tee make.log
#############################################################

project=$1

# pear command wrapper
_pear(){
    if [ -e ./pear/pear ]; then
        echo "####################[$1]>>>>>>>>>>"
        ./pear/pear -c .pearrc $1
        echo "####################[$1]<<<<<<<<<<"
    else
        echo "ERROR!!!!!!!!!!!!!!NOT FOUND ./pear/pear "
        exit
    fi
}

# prepare
mkdir libs
cd libs

# install pear
pear config-create `pwd` .pearrc
pear -c .pearrc config-set auto_discover 1
pear -c .pearrc config-set preferred_state alpha
pear -c .pearrc channel-update pear.php.net
pear -c .pearrc install PEAR
pear -c .pearrc upgrade pear/PEAR
pear -c .pearrc upgrade-all

# install BEAR
_pear "channel-discover pear.bear-project.net"
_pear "install -a bear/BEAR-beta"

# phpunitがエラーとなり実行できなかったので追加。インストールもできなかったので--forceインストール。
_pear "install --alldeps --force phpunit/DbUnit"
_pear "install --alldeps --force phpunit/PHPUnit_Selenium"
_pear "install --alldeps --force phpunit/PHPUnit_Story"

# print commands.
cd ..
echo "">_TMPMESSAGE
echo "### run these commands. ### ">>_TMPMESSAGE
echo "./libs/pear/bear init-app $project -c ./libs/.pearrc">>_TMPMESSAGE
echo "mv libs $project/">>_TMPMESSAGE
echo "cd $project/">>_TMPMESSAGE
echo "mv * ../">>_TMPMESSAGE
echo "cd ..">>_TMPMESSAGE
echo "rm -fr $project/">>_TMPMESSAGE
echo "REPLACE='php_value include_path \"$HOME/ex/$project/libs/pear/php:$HOME/ex/$project:$HOME/ex/$project/libs/pear/php/BEAR/vendors/PEAR:.\"'">>_TMPMESSAGE
echo "sed --in-place -r -e \"s#^php_value\sinclude_path.*#\$REPLACE#g\" htdocs/.htaccess">>_TMPMESSAGE
echo "### run these commands. ### ">>_TMPMESSAGE
cat _TMPMESSAGE
rm _TMPMESSAGE

