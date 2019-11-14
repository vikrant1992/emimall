#!/bin/bash
# starting nginx service

sudo sh /home/ec2-user/permission.sh

rm -rf /app/magento/app/code
rm -rf /app/magento/app/design
rm -rf /app/magento/vendor/mirasvit

cp -rf /app/magento/emimall-uat/app/code /app/magento/app
cp -rf /app/magento/emimall-uat/app/design /app/magento/app
cp -rf /app/magento/emimall-uat/customcron /app/magento
cp -rf /app/magento/emimall-uat/vendor /app/magento
cp -f /app/magento/emimall-uat/composer.json /app/magento
cp -f /app/magento/emimall-uat/composer.lock /app/magento

chmod -R 0777 /app/magento/generated/
chmod -R 0777 /app/magento/pub/static/

php /app/magento/bin/magento setup:upgrade
php /app/magento/bin/magento setup:di:compile
php /app/magento/bin/magento setup:static-content:deploy -f

