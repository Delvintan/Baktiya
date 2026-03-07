# ERP System — Sales & Procurement Module

## Langkah Install (Windows)

### 1. Pastikan sudah terinstall:
- PHP 8.2+ (https://windows.php.net/download)
- Composer (https://getcomposer.org)
- MySQL (https://dev.mysql.com/downloads/installer)

### 2. Cek instalasi di terminal VSCode:
```
php -v
composer -v
mysql --version
```

### 3. Buat project Laravel baru:
```
composer create-project laravel/laravel erp-app
cd erp-app
composer require laravel/sanctum
php artisan install:api
```

### 4. Copy file dari folder ini ke erp-app:
```
app/Http/Controllers/  → erp-app/app/Http/Controllers/
app/Http/Middleware/   → erp-app/app/Http/Middleware/
app/Models/            → erp-app/app/Models/
database/migrations/   → erp-app/database/migrations/
database/seeders/      → erp-app/database/seeders/
routes/api.php         → erp-app/routes/api.php   (REPLACE)
public/*.html          → erp-app/public/
```

### 5. Edit file .env:
```
DB_DATABASE=erp_sales
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Buat database di MySQL:
```
mysql -u root -e "CREATE DATABASE erp_sales;"
```

### 7. Daftarkan middleware di bootstrap/app.php:
Tambahkan ini di dalam ->withMiddleware():
```php
$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

### 8. Jalankan:
```
php artisan migrate
php artisan db:seed
php artisan serve
```

### 9. Buka browser:
http://localhost:8000

---

## Akun Login:
| Role        | Email                  | Password |
|-------------|------------------------|----------|
| Admin       | admin@erp.com          | password |
| Sales       | sales@erp.com          | password |
| Procurement | procurement@erp.com    | password |
