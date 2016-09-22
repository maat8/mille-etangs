#!/bin/bash
DIR=`php -r "echo dirname(dirname(realpath('$0')));"`
cd "$DIR"

rm -Rf app/cache/* app/logs/*

mkdir web/uploads
chmod 777 web/uploads

if [ ! -f "app/config/parameters.yml" ]; then
cp app/config/parameters.yml.dist app/config/parameters.yml
fi

./app/console doctrine:mongodb:fixtures:load -n
