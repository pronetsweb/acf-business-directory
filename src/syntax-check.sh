#!/bin/sh
# Composer's autoloader obscures syntax errors, so a script to check syntax.
find . -iname '*.php' -exec php -l '{}' \; | grep '^No syntax errors' -v 
