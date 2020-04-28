#!/bin/bash

if test $1 == "sniff"; then
    vendor/bin/phpcs ./src -v --extensions=html,php,phtml
fi;

printf "\n";
