#!/bin/bash

if test $1 && test $1 == "sniff"; then
    vendor/bin/phpcs ./src --extensions=html,php,phtml
    COMMAND="vendor/bin/phpcs -sv --colors";
    EXTENSIONS="--extensions=html,php,phtml"

    printf "\nTesting with PEAR standard:\n";
    $COMMAND ./src $EXTENSIONS --standard=PEAR;
    printf "\nDONE!\n";

    printf "\nTesting with PSR2 standard:\n";
    $COMMAND ./src $EXTENSIONS --standard=PSR2;
    printf "\nDONE!\n";
fi;

printf "\n";
