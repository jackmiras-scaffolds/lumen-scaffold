#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

echo "################################################################################"
echo "# PHP CPD                                                                      #"
echo "################################################################################"

echo "" && ./vendor/bin/phpcpd --fuzzy app/ config/ routes/ database/ && echo ""

echo "################################################################################"
echo "# PHP PSALM                                                                    #"
echo "################################################################################"

echo "" && ./vendor/bin/psalm \
    --no-cache \
    --no-file-cache \
    --no-reflection-cache \
    --show-info=true && echo ""

echo "################################################################################"
echo "# Larastan                                                                     #"
echo "################################################################################"

echo "" && ./vendor/bin/phpstan analyse --configuration=phpstan.neon --memory-limit=2G
