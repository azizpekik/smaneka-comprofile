#!/bin/bash
# Script untuk update .env di hosting

# Upload file ini ke hosting lalu jalankan:
# bash update-hosting-env.sh

# Atau copy-paste perintah ini langsung di hosting:

sed -i 's/^APP_NAME=.*/APP_NAME="SMAN 1 Kepanjen"/' .env
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env
sed -i 's/^APP_TIMEZONE=.*/APP_TIMEZONE=Asia\/Jakarta/' .env
sed -i 's|^APP_URL=.*|APP_URL=https://sman1kepanjen.sch.id|' .env
sed -i 's/^SESSION_DOMAIN=.*/SESSION_DOMAIN=.sman1kepanjen.sch.id/' .env
sed -i 's/^SESSION_SECURE_COOKIE=.*/SESSION_SECURE_COOKIE=true/' .env

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan optimize

echo "✅ .env berhasil diupdate!"
