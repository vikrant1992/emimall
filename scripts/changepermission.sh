#!/bin/bash

chown emimall-prod:nginx -R /var/www/html

find /var/www/html -type d -exec chmod 755 {} \;

