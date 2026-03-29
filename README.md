# SMAN 1 Kepanjen - Admin Panel

Website Company Profile SMAN 1 Kepanjen dengan Admin Panel menggunakan Filament v3.

## Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Admin Panel:** Filament v3 (TALL Stack: Tailwind, Alpine.js, Laravel, Livewire)
- **Database:** MySQL
- **Permission:** Spatie Laravel Permission

## Installation

### 1. Clone Repository

```bash
git clone <repository-url>
cd comprof-smaneka
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Configure database di file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=comprof_smaneka
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Seed Roles & Users

```bash
php artisan db:seed
```

Ini akan membuat:
- **Super Admin:** admin@sman1kepanjen.sch.id / password
- **Editor:** editor@sman1kepanjen.sch.id / password

### 6. Create Storage Symlink

```bash
php artisan storage:link
```

### 7. Akses Admin Panel

Jalankan development server:
```bash
php artisan serve
```

Akses admin panel di: `http://localhost:8000/admin`

## User Roles & Permissions

### Super Admin
- Full access ke semua fitur
- User management
- Role management
- Website settings
- Menus management

### Editor / Operator
- Content management only:
  - News (Posts)
  - Pages
  - Teachers
  - Achievements
  - Gallery (Albums & Photos)
  - Extracurriculars
  - Guest Book
  - Menus

## Features

### Admin Panel Features

1. **Dashboard**
   - Statistik konten (Total Berita, Guru, Prestasi, Ekstrakurikuler)

2. **Content Management**
   - **Posts/Berita:** RichEditor, image upload dengan optimasi, kategori, tags
   - **Pages/Halaman:** RichEditor untuk konten statis
   - **Categories:** Kategori berita
   - **Tags:** Tag untuk berita

3. **School Profile**
   - **Teachers:** Data guru dengan foto profil
   - **Achievements:** Prestasi siswa dengan foto
   - **Extracurriculars:** Kegiatan ekstrakurikuler

4. **Gallery**
   - **Albums:** Album foto dengan thumbnail
   - **Galleries:** Foto dalam album (Relation Manager)

5. **Guest Book**
   - Buku tamu digital

6. **Settings**
   - **Menus:** Navigation menu management
   - **Settings:** Website configuration (Super Admin only)

### Image Upload Features

- Max file size: 2MB
- Accepted formats: JPG, PNG, JPEG
- Auto image compression
- Organized directory structure:
  - `posts/thumbnails/`
  - `teachers/photos/`
  - `achievements/`
  - `extracurriculars/`
  - `albums/thumbnails/`
  - `galleries/`

## Database Schema

### Core Tables
- `users` - User accounts
- `settings` - Website settings (key-value)
- `menus` - Navigation menus
- `posts` - News/blog posts
- `categories` - Post categories
- `tags` - Post tags
- `pages` - Static pages
- `teachers` - Teacher profiles
- `albums` - Photo albums
- `galleries` - Photo gallery items
- `achievements` - Student achievements
- `extracurriculars` - Extracurricular activities
- `guest_books` - Guest book entries

### Permission Tables (Spatie)
- `model_has_roles`
- `model_has_permissions`
- `role_has_permissions`
- `roles`
- `permissions`

## Development

### Create New Resource

```bash
php artisan make:filament-resource ModelName --generate
```

### Create New Widget

```bash
php artisan make:filament-widget WidgetName
```

### Clear Caches

```bash
php artisan optimize:clear
```

## Security Notes

- CSRF protection enabled
- File upload validation (max 2MB, jpg/png only)
- Role-based access control
- Super Admin role required for Settings management

## Next Steps (Frontend)

Untuk melengkapi website, perlu ditambahkan:
1. Frontend Blade templates dengan TailwindCSS
2. HomeController untuk landing page
3. PostController untuk berita
4. PageController untuk halaman statis
5. TeacherController untuk daftar guru
6. AchievementController untuk prestasi

## Credits

Developed for SMAN 1 Kepanjen
# smaneka-comprofile
