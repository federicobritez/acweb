#!/bin/bash

rm src/AppBundle/Entity/*.php
rm src/AppBundle/Resources/config/doctrine/*.xml

php bin/console doctrine:mapping:import --force AppBundle xml
php bin/console doctrine:generate:entities AppBundle
