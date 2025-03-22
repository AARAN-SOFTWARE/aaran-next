# Frequently Asked Questions (FAQ)

## 1. General
### **1.1 What is multi-tenancy in Aaran-BMS?**
Multi-tenancy allows multiple organizations (tenants) to use the same system while keeping their data isolated. Aaran-BMS supports different tenancy models, including **database-per-tenant**, **schema-per-tenant**, and **shared-database with tenant ID**.

### **1.2 What are the benefits of using multi-tenancy?**
- **Cost Efficiency** – Reduces infrastructure costs by sharing resources.
- **Scalability** – Supports dynamic tenant provisioning.
- **Data Isolation** – Ensures tenant data remains separate and secure.
- **Centralized Management** – Easier to maintain and deploy updates.

---

## 2. Tenant Management
### **2.1 How do I create a new tenant?**
Use the following Artisan command:
```sh
php artisan tenants:create mytenant.example.com
```
This will generate a new tenant entry and configure the necessary database connections.

### **2.2 How do I delete a tenant?**
Run the command:
```sh
php artisan tenants:delete mytenant.example.com
```
This will remove the tenant from the system.

### **2.3 Can I migrate data for a specific tenant?**
Yes, run:
```sh
php artisan tenants:migrate --tenant=mytenant.example.com
```
This will apply pending migrations only for the specified tenant.

---

## 3. Authentication & Security
### **3.1 How does authentication work for tenants?**
Each tenant has its own user database. Laravel Sanctum is used for API authentication, ensuring users can only access their respective tenant’s data.

### **3.2 How do I enforce tenant-based access control?**
You can use **middleware** to restrict access to tenant-specific resources:
```php
Route::middleware(['auth', 'tenant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

---

## 4. Performance & Optimization
### **4.1 How can I optimize queries for multi-tenancy?**
- Use **indexed tenant_id columns**.
- Enable **query caching**.
- Optimize database connections for high-traffic tenants.

### **4.2 How do I manage caching for different tenants?**
Use tenant-specific cache keys:
```php
Cache::put("tenant_{$tenantId}_settings", $settings, 3600);
```

---

## 5. Deployment & Maintenance
### **5.1 How do I back up tenant databases?**
Use Laravel’s backup package:
```sh
php artisan backup:run
```
Schedule automatic backups for each tenant.

### **5.2 How can I monitor tenant performance?**
Use logging and monitoring tools like **Laravel Telescope**, **New Relic**, or **Grafana** to track tenant-specific performance metrics.

---

## 6. Troubleshooting
### **6.1 I get a ‘Tenant Not Found’ error. What should I do?**
- Ensure the tenant is correctly registered in the system.
- Verify that the subdomain or request URL is mapped correctly.
- Check the tenant identification middleware.

### **6.2 Database connection is failing for a tenant. How do I fix it?**
- Ensure the tenant database exists and credentials are correct.
- Run `php artisan tenants:migrate` to apply migrations.
- Check `.env` settings for dynamic database switching.

---

## Conclusion
This FAQ covers the most common questions related to multi-tenancy in Aaran-BMS. If you have additional questions, refer to the documentation or contact the development team. 🚀
