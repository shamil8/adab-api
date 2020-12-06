#!/bin/bash

if test -z $1 ; then
    echo "=== XDEBUG skipped ==="
else
    echo "=== Installing XDEBUG... ==="
    pecl install xdebug && docker-php-ext-enable xdebug
fi
