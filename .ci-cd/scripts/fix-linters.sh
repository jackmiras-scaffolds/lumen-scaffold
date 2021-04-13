#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# PHP CS Fixer                                                                 #"
echo "################################################################################"

./vendor/bin/php-cs-fixer \
    --config=.php_cs \
    --using-cache=no \
    --stop-on-violation \
    fix app routes config database database