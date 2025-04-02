# 🅰️🌿 Laravel 12 🏗️ Setup with Full

This document provides step-by-step instructions for setting up **Aaran-BMS**.

## 1️⃣ Prerequisites
Before installing, make sure you have:
- PHP 8.2+
- Composer
- MySQL or PostgreSQL (or another supported database)
- Node.js & NPM (for frontend assets if needed)

## 2️⃣ Install Laravel 12
Run the following command to create a new Laravel project:

```sh
  composer global require laravel/installer
```

For a fully-featured, graphical PHP installation & management

## ️ ️ Creating an app 🏛️

```sh
  laravel new example-app
```

Once the App has been created, you can start Laravel's 🚀 </br>
local development 💻 server, ⏳ queue 👩‍💻 worker, & Vite
server using the dev Composer script:

```sh
  cd example-app
  npm install && npm run build
  composer run dev
```

Once you have started the 💡 development server,
your app️ will be accessible in your browser at http://localhost:8000.

## ** 3️⃣ Install Dependencies 📦**

### Install required packages:

#### Install Laravel barryvdh debug bar

```sh
  composer require barryvdh/laravel-debugbar --dev
```
#### Install Laravel barryvdh dom pdf

```sh
   composer require barryvdh/laravel-dompdf
```

#### Install Laravel intervention image

```sh
   composer require intervention/image-laravel
```
Publish the Image configuration:

```sh
   php artisan vendor:publish --provider="Intervention\Image\Laravel\ServiceProvider"
```

#### Install Laravel maatwebsite excel

```sh
    composer require maatwebsite/excel
```
Publish the Excel configuration:

```sh
     php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
```

#### Install Laravel Sanctum (API Authentication)

```sh
     php artisan install:api
```

Publish the Sanctum configuration:

```sh
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```


## 5 Set Up Environment if not present

Copy the `.env` file and generate the application key:

```sh
  cp .env.example .env
```

```sh
  php artisan key:generate
```


## 4️⃣ Databases & Migrations

```sh
      DB_CONNECTION=mariadb
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=laravel
      DB_USERNAME=root
      DB_PASSWORD=
```

```sh
     php artisan migrate
```
## Next Steps
Now that the base setup is ready, proceed with [Modular Architecture Setup](modular-architecture.md).
