# 🚀 QUICK DEPLOYMENT GUIDE - SMANeka CMS

## ⚡ Fast Track Deployment (10 Minutes)

### 1️⃣ Persiapan (2 Menit)
```bash
# Di komputer lokal
cd comprof-smaneka
git init
git add .
git commit -m "Initial commit"
# Buat repo di GitHub, lalu:
git remote add origin https://github.com/username/comprof-smaneka.git
git push -u origin main
```

### 2️⃣ Upload ke Hosting (3 Menit)
```bash
# SSH ke hosting
ssh user@domain.com

# Clone repository
cd public_html
git clone https://github.com/username/comprof-smaneka.git
cd comprof-smaneka

# Install dependencies
composer install --optimize-autoloader --no-dev
```

### 3️⃣ Setup Database (2 Menit)
```bash
# Di cPanel → MySQL Databases
# 1. Buat database: username_smaneka
# 2. Buat user: username_sman
# 3. Generate password
# 4. Assign user ke database dengan ALL PRIVILEGES
```

### 4️⃣ Konfigurasi (2 Menit)
```bash
# Di folder comprof-smaneka
cp .env.example .env
nano .env
```

**Update bagian ini:**
```env
APP_KEY=base64:GENERATE_LATER
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_DATABASE=username_smaneka
DB_USERNAME=username_sman
DB_PASSWORD=your_password
```

```bash
# Generate APP_KEY
php artisan key:generate
```

### 5️⃣ Final Setup (1 Menit)
```bash
php artisan migrate --force
php artisan storage:link
chmod -R 755 storage bootstrap/cache
php artisan optimize
```

**✅ DONE!** Kunjungi `https://domain-anda.com`

---

## 📁 Struktur Upload

```
/home/username/
└── comprof-smaneka/          ← Upload SEMUA file kesini
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/               ← Isi folder ini ke public_html
    ├── resources/
    ├── routes/
    ├── .env                  ← JANGAN upload ke Git!
    └── .env.example          ← Upload ini ke Git

/home/username/public_html/   ← Isi dari public/
├── index.php
├── .htaccess
├── css/
├── js/
├── images/
└── storage/                  ← Symlink
```

---

## 🔧 One-Liner Commands

### Backup Database
```bash
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
```

### Restore Database
```bash
mysql -u username -p database_name < backup_20240101.sql
```

### Update dari Git
```bash
cd /home/user/comprof-smaneka
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan optimize
```

### Clear Cache
```bash
php artisan optimize:clear
```

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

---

## 🆘 Quick Troubleshooting

### 500 Error
```bash
chmod -R 755 storage bootstrap/cache
php artisan optimize:clear
```

### Database Error
```bash
nano .env  # Check credentials
php artisan db:show  # Test connection
```

### Images Not Showing
```bash
php artisan storage:link
chmod -R 755 storage/app/public
```

### Permission Denied
```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 755 storage bootstrap/cache
```

---

## 📞 Checklist Cepat

### Pre-Deploy
- [ ] `.env` tidak di-commit ke Git
- [ ] `npm run build` sudah dijalankan
- [ ] Database credentials siap
- [ ] APP_KEY di-generate

### Deploy
- [ ] Files uploaded
- [ ] Composer install
- [ ] .env configured
- [ ] Database migrated
- [ ] Storage linked
- [ ] Permissions set
- [ ] Optimized

### Post-Deploy
- [ ] Homepage loads
- [ ] Admin login works
- [ ] Images upload works
- [ ] No errors in logs

---

## 🔐 Security Must-Do

```bash
# Set production mode
echo "APP_DEBUG=false" >> .env
echo "APP_ENV=production" >> .env

# Secure .env
chmod 644 .env

# Set permissions
chmod -R 755 storage bootstrap/cache

# Enable SSL (di cPanel)
# SSL/TLS → Let's Encrypt → Activate
```

---

## 📊 Monitoring Commands

```bash
# Check disk space
df -h

# Check PHP version
php -v

# Check Laravel version
php artisan --version

# View error logs
tail -f storage/logs/laravel.log

# Check database size
mysql -u user -p -e "SELECT table_schema AS 'Database', 
ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)' 
FROM information_schema.tables 
GROUP BY table_schema;"
```

---

## 🎯 Production Checklist

```bash
# Run all production commands
cd /home/user/comprof-smaneka

# 1. Install dependencies
composer install --optimize-autoloader --no-dev

# 2. Clear cache
php artisan optimize:clear

# 3. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 4. Set permissions
chmod -R 755 storage bootstrap/cache

# 5. Create storage link
php artisan storage:link

# 6. Migrate database
php artisan migrate --force
```

---

## 📧 Email Setup (Gmail)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password  # Bukan password biasa!
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Get App Password:**
1. Buka https://myaccount.google.com/security
2. Enable 2-Step Verification
3. App Passwords → Generate
4. Use that password di `.env`

---

## 🎉 Deployment Complete!

Test URL:
- Homepage: `https://domain-anda.com`
- Admin: `https://domain-anda.com/admin`
- News: `https://domain-anda.com/berita`

**Selamat! Website sudah live! 🚀**
