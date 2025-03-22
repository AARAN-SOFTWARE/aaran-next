# Deployment & Maintenance Guide for Aaran-BMS Multi-Tenancy

## 1. Introduction
This document outlines the best practices for **deploying and maintaining** the multi-tenant architecture in Aaran-BMS. It includes environment setup, database migrations, monitoring, and optimization techniques.

---

## 2. Deployment Process
### **2.1 Environment Setup**
Ensure all required environment variables are correctly set in `.env`:
```ini
APP_ENV=production
APP_KEY=base64:...
DB_CONNECTION=mysql
QUEUE_CONNECTION=redis
CACHE_DRIVER=redis
SESSION_DRIVER=database
MULTI_TENANCY_MODE=database_per_tenant
```

### **2.2 Database Migrations**
Run system-level migrations:
```sh
php artisan migrate --seed
```
For tenant-specific migrations:
```sh
php artisan tenants:migrate
```

### **2.3 Web Server Configuration**
For **Nginx**, configure tenant subdomains:
```nginx
server {
    server_name *.example.com;
    root /var/www/aaran-bms/public;
    location / {
        try_files $uri /index.php?$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

For **Apache**, enable wildcard subdomains:
```apache
<VirtualHost *:80>
    ServerAlias *.example.com
    DocumentRoot /var/www/aaran-bms/public
    <Directory /var/www/aaran-bms>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### **2.4 Caching & Performance Optimization**
Run the following to optimize configuration:
```sh
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
Enable Redis for session and cache handling.

---

## 3. Maintenance & Monitoring
### **3.1 Tenant Provisioning**
Automate tenant creation:
```sh
php artisan tenants:create mytenant.example.com
```
To remove a tenant:
```sh
php artisan tenants:delete mytenant.example.com
```

### **3.2 Database Backups**
Schedule daily backups using Laravel Backup package:
```sh
php artisan backup:run
```

### **3.3 Logs & Debugging**
Use Laravel Log Viewer to track errors:
```sh
php artisan log:clear
```
For real-time logs:
```sh
tail -f storage/logs/laravel.log
```

### **3.4 Security Updates**
- Regularly update Laravel and dependencies:
```sh
composer update
```
- Apply OS-level security patches.
- Restrict SSH access and enforce **firewall rules**.

---

## 4. Scaling & Load Balancing
- Use **horizontal scaling** with multiple app servers.
- Deploy a **load balancer (Nginx, AWS ALB)**.
- Enable **database replication** for read-heavy workloads.
- Use **queue workers** for async processing.

---

## Conclusion
Following these **deployment and maintenance practices** ensures **stability, security, and scalability** for Aaran-BMS in a multi-tenant environment. 🚀
