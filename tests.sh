#!/bin/bash

if [ "$2" == "-db" ]
then
echo "rebuilding database ..."
symfony console doctrine:schema:drop -n -q --force --full-database
rm migrations/*.php
symfony console make:migration
symfony console doctrine:migrations:migrate -n -q
symfony console doctrine:fixtures:load -n -q
fi

if [ -n "$1" ]
then
php bin/phpunit $1
else
php bin/phpunit
fi