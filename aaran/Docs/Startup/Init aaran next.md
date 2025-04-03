# 🅰️🌿 Aaran Next

This document provides step-by-step instructions for setting up **Aaran-Next**.

## 📥 Cloning the Repository

```sh
  git clone https://github.com/<YourUser>/aaran-next.git
  cd aaran-next
```

## 🚀 Starting the Application

Once the app has been cloned, update dependencies and start the local development environment:

```sh
  composer update
```

```sh
  npm install && npm run build
```

After starting the development server, your app will be accessible at:

```
http://localhost:8000
```

## 🛠️ Setting Up Environment Variables

If the `.env` file is not present, copy the example file and generate the application key:

```sh
  cp .env.example .env
  php artisan key:generate
```

## 🗄️ Configuring the Database

Update your `.env` file with the correct database credentials:

```sh
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Run database migrations:

```sh
  php artisan migrate
```

Start the Laravel server:

```sh
  php artisan serve
```

## 📌 Next Steps

Now that the base setup is complete, proceed with [Modular Architecture Setup](modular-architecture.md).
