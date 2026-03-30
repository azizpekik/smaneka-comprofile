#!/bin/bash
# Script untuk setup role di hosting
# Cara pakai:
# 1. Upload file ini ke hosting
# 2. Jalankan: bash setup-roles.sh

cd /home/u343856082/smaneka-comprofile

echo "🔄 Menjalankan RolePermissionSeeder..."
php artisan db:seed --class=RolePermissionSeeder

echo ""
echo "🔄 Clear cache..."
php artisan optimize:clear

echo ""
echo "✅ Setup selesai!"
echo "Login dengan:"
echo "  Email: admin@sman1kepanjen.sch.id"
echo "  Password: password"
