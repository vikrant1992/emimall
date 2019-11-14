#!/bin/bash

sudo sh /home/ec2-user/permission.sh

find /app/magento -type f -exec chmod 644 {} \;                        // 644 permission for files

find /app/magento -type d -exec chmod 755 {} \;                        // 755 permission for directory

chmod 0777 /app/magento/app/etc
chmod 644 /app/magento/app/etc/*.xml
chmod -R 0777 /app/magento/var/
chmod -R 0777 /app/magento/generated/
chmod -R 0777 /app/magento/pub/static/
chmod -R 0777 /app/magento/pub/media/

php /app/magento/bin/magento cache:flush

