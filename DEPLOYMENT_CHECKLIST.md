# 📋 DEPLOYMENT CHECKLIST - SMANeka CMS

**Project:** SMANeka School Management System  
**Version:** 1.0.0  
**Date:** _______________  
**Deployed by:** _______________

---

## ✅ PRE-DEPLOYMENT (Di Lokal)

### 1. Persiapan File
- [ ] Backup database lokal (jika ada data penting)
- [ ] Generate APP_KEY baru: `php artisan key:generate`
- [ ] Copy APP_KEY ke catatan aman
- [ ] Update `.env.example` dengan konfigurasi production
- [ ] Hapus file `.env` dari project (JANGAN upload!)
- [ ] Clear cache: `php artisan optimize:clear`
- [ ] Test build: `npm run build`
- [ ] Commit semua perubahan ke Git

### 2. Git Setup
- [ ] Initialize Git: `git init`
- [ ] Pastikan `.gitignore` sudah ada
- [ ] Add semua file: `git add .`
- [ ] Commit: `git commit -m "Production release"`
- [ ] Buat repository di GitHub
- [ ] Push ke GitHub: `git push -u origin main`

### 3. File yang HARUS Ada
- [ ] `app/` folder
- [ ] `bootstrap/` folder
- [ ] `config/` folder
- [ ] `database/` folder
- [ ] `public/` folder
- [ ] `resources/` folder
- [ ] `routes/` folder
- [ ] `composer.json`
- [ ] `package.json`
- [ ] `.env.example`
- [ ] `artisan`

### 4. File yang TIDAK BOLEH Upload
- [ ] `.env` ❌
- [ ] `node_modules/` ❌
- [ ] `vendor/` ❌
- [ ] `.git/` ❌
- [ ] `storage/logs/*.log` ❌
- [ ] `.DS_Store` ❌

---

## 🚀 DEPLOYMENT (Di Hosting)

### 1. Database Setup (cPanel)
- [ ] Login ke cPanel
- [ ] Buka **MySQL Databases**
- [ ] Buat database baru: `___________`
- [ ] Buat user database: `___________`
- [ ] Generate password kuat: `___________`
- [ ] Assign user ke database dengan **ALL PRIVILEGES**
- [ ] Catat kredensial database

### 2. Upload Files

#### Opsi A: Via Git (Recommended) ⭐
- [ ] SSH ke hosting: `ssh user@domain.com`
- [ ] Navigate ke folder: `cd /home/user/`
- [ ] Clone repository: `git clone https://github.com/username/comprof-smaneka.git`
- [ ] Masuk folder: `cd comprof-smaneka`

#### Opsi B: Via FTP/cPanel
- [ ] Install Node.js lokal: `npm install`
- [ ] Build assets: `npm run build`
- [ ] Zip semua file (kecuali vendor & node_modules)
- [ ] Upload ke `/home/user/comprof-smaneka/`
- [ ] Extract file
- [ ] Upload isi folder `public/` ke `public_html/`

### 3. Install Dependencies
- [ ] Install Composer (jika belum):
  ```bash
  curl -sS https://getcomposer.org/installer | php
  sudo mv composer.phar /usr/local/bin/composer
  ```
- [ ] Install PHP dependencies:
  ```bash
  composer install --optimize-autoloader --no-dev
  ```

### 4. Environment Setup
- [ ] Copy environment file: `cp .env.example .env`
- [ ] Edit `.env` dengan kredensial hosting:
  ```bash
  nano .env
  ```
- [ ] Update konfigurasi berikut:
  ```env
  APP_NAME=SMANeka
  APP_ENV=production
  APP_KEY=base64:_______________________________
  APP_DEBUG=false
  APP_URL=https://domain-anda.com
  
  DB_CONNECTION=mysql
  DB_HOST=localhost
  DB_PORT=3306
  DB_DATABASE=_________________
  DB_USERNAME=_________________
  DB_PASSWORD=_________________
  
  FILESYSTEM_DISK=public
  ```
- [ ] Generate APP_KEY: `php artisan key:generate`

### 5. Database Migration
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed data (optional): `php artisan db:seed --class=TestSeeder --force`
- [ ] Verify database: `php artisan db:show`

### 6. Storage Setup
- [ ] Create storage link: `php artisan storage:link`
- [ ] Set permissions:
  ```bash
  chmod -R 755 storage bootstrap/cache
  chown -R www-data:www-data storage bootstrap/cache
  ```

### 7. Web Server Configuration

#### Apache (.htaccess)
- [ ] Upload `.htaccess` ke `public_html/`:
  ```apache
  <IfModule mod_rewrite.c>
      RewriteEngine On
      RewriteCond %{REQUEST_FILENAME} !-d
      RewriteCond %{REQUEST_FILENAME} !-f
      RewriteRule ^ index.php [L]
  </IfModule>
  ```

#### Nginx (jika pakai)
- [ ] Update server block configuration
- [ ] Reload Nginx: `sudo systemctl reload nginx`

### 8. Optimization
- [ ] Cache config: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`
- [ ] Optimize autoload: `composer dump-autoload --optimize`

---

## 🔒 SECURITY SETUP

### 1. File Permissions
- [ ] `.env` file: `chmod 644 .env`
- [ ] Storage folder: `chmod -R 755 storage/`
- [ ] Cache folder: `chmod -R 755 bootstrap/cache/`
- [ ] Public folder: `chmod -R 755 public/`

### 2. Environment Security
- [ ] Set `APP_DEBUG=false` di `.env`
- [ ] Set `APP_ENV=production` di `.env`
- [ ] Pastikan `.env` tidak accessible via browser

### 3. SSL/HTTPS
- [ ] Aktifkan SSL di cPanel (Let's Encrypt)
- [ ] Force HTTPS redirect di `.htaccess`:
  ```apache
  RewriteEngine On
  RewriteCond %{HTTPS} off
  RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
  ```
- [ ] Test HTTPS: `https://domain-anda.com`

---

## ✅ TESTING CHECKLIST

### Homepage & Public Pages
- [ ] `https://domain-anda.com/` - Homepage loads
- [ ] `https://domain-anda.com/berita/` - News page loads
- [ ] `https://domain-anda.com/guru-staff/` - Teachers page loads
- [ ] `https://domain-anda.com/ekstrakurikuler/` - Extracurricular page loads
- [ ] `https://domain-anda.com/galeri/` - Gallery page loads
- [ ] `https://domain-anda.com/kontak/` - Contact page loads

### Admin Panel
- [ ] `https://domain-anda.com/admin/` - Admin login page
- [ ] Login dengan super-admin
- [ ] Dashboard loads dengan widgets
- [ ] Menu navigasi berfungsi
- [ ] Can create new post
- [ ] Can upload image
- [ ] Can edit settings
- [ ] Can manage users

### Features Testing
- [ ] Image upload berfungsi
- [ ] Image display di frontend berfungsi
- [ ] Search functionality berfungsi
- [ ] Pagination berfungsi
- [ ] Form submissions berfungsi
- [ ] Email sending (test contact form)

### Database
- [ ] Connection stable
- [ ] Migrations ran successfully
- [ ] Seed data populated
- [ ] No SQL errors in logs

### Performance
- [ ] Page load time < 3 seconds
- [ ] Images optimized
- [ ] No console errors
- [ ] Mobile responsive

---

## 🔧 POST-DEPLOYMENT

### 1. Clear & Optimize
```bash
php artisan optimize:clear
php artisan optimize
```

### 2. Setup Cron Job (Optional)
- [ ] Add to crontab:
  ```bash
  * * * * * cd /home/user/comprof-smaneka && php artisan schedule:run >> /dev/null 2>&1
  ```

### 3. Setup Email (Optional)
- [ ] Configure SMTP di `.env`:
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.gmail.com
  MAIL_PORT=587
  MAIL_USERNAME=your-email@gmail.com
  MAIL_PASSWORD=your-app-password
  MAIL_ENCRYPTION=tls
  ```
- [ ] Test email: `php artisan mail:test`

### 4. Monitoring Setup
- [ ] Enable error logging: `LOG_CHANNEL=daily`
- [ ] Setup uptime monitoring (UptimeRobot, etc.)
- [ ] Setup error tracking (Sentry, etc.)

---

## 📊 MAINTENANCE SCHEDULE

### Daily
- [ ] Check error logs: `tail -f storage/logs/laravel.log`
- [ ] Monitor disk space
- [ ] Check database size

### Weekly
- [ ] Backup database:
  ```bash
  mysqldump -u user -p database > backup_$(date +%Y%m%d).sql
  ```
- [ ] Backup files:
  ```bash
  tar -czf backup_$(date +%Y%m%d).tar.gz /home/user/comprof-smaneka
  ```
- [ ] Clear old logs: `php artisan log:rotate`

### Monthly
- [ ] Update dependencies: `composer update`
- [ ] Update npm packages: `npm update`
- [ ] Review error logs
- [ ] Check security updates
- [ ] Test backup restoration

---

## 🆘 TROUBLESHOOTING

### Common Issues

**500 Internal Server Error**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan optimize:clear

# Check permissions
chmod -R 755 storage bootstrap/cache
```

**Database Connection Error**
```bash
# Test connection
php artisan db:show

# Check .env credentials
nano .env
```

**Permission Denied**
```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 755 storage bootstrap/cache
```

**Images Not Showing**
```bash
# Recreate storage link
php artisan storage:link

# Check file permissions
chmod -R 755 storage/app/public
```

**Composer Memory Error**
```bash
php -d memory_limit=-1 /usr/local/bin/composer install --optimize-autoloader --no-dev
```

---

## 📞 EMERGENCY CONTACTS

- **Hosting Support:** _______________
- **Domain Registrar:** _______________
- **SSL Provider:** _______________
- **Developer:** _______________

---

## 📝 DEPLOYMENT LOG

| Date | Version | Changes | Deployed By | Status |
|------|---------|---------|-------------|--------|
|      | 1.0.0   | Initial Deployment |             |        |
|      |         |         |             |        |
|      |         |         |             |        |

---

## ✨ DEPLOYMENT COMPLETE!

**Final Verification:**
- [ ] All tests passed
- [ ] No errors in logs
- [ ] SSL certificate active
- [ ] Backups configured
- [ ] Monitoring enabled
- [ ] Documentation updated

**Signed:** _______________  
**Date:** _______________  
**Time:** _______________

---

> 💡 **Tips:**
> - Selalu backup sebelum deployment
> - Test di staging environment dulu
> - Deploy saat traffic rendah
> - Monitor logs setelah deployment
> - Keep dependencies updated

**Good Luck! 🚀**
