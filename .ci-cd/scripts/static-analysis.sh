#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# PHP CPD                                                                      #"
echo "################################################################################"

echo "" && ./vendor/bin/phpcpd --fuzzy app/ config/ routes/ database/ && echo ""

echo "################################################################################"
echo "# Larastan                                                                     #"
echo "################################################################################"

echo "" && ./vendor/bin/phpstan analyse --configuration=phpstan.neon --memory-limit=2G
