### **🔹 Step 1: Multi-Tenancy Core Setup (Enterprise-Grade)**

Since we are building **multi-tenancy from scratch** (not using any package), we need a **solid foundation**.

---

## **1️⃣ Multi-Tenancy Approach (Choose One)**
There are **3 ways** to handle multi-tenancy:

| Approach       | Data Separation | Pros | Cons | Best For |
|--------------|--------------|------|------|---------|
| **Single DB (Row-Level)**  | Tenants share one DB, identified by `tenant_id`. | Simple, fast. | Risk of data leaks. | Small apps, low tenants. |
| **Multi-DB (Database Per Tenant)** | Each tenant has its own database. | Scalable, secure. | More complex management. | Enterprise SaaS, large tenants. |
| **Schema-Based (PostgreSQL only)** | One DB, but separate schemas per tenant. | Secure, easier than multi-DB. | Only works with PostgreSQL. | Mid-sized apps. |

✔ **For Aaran-BMS (Enterprise-Level), we go with Multi-DB (Database Per Tenant).**

---

## **2️⃣ Project Folder Structure**
Since the **`Aaran` folder is outside `app/`**, we structure it like this:

```
/Aaran  
 ├── Core/  
 │   ├── Tenant/          # Multi-tenancy core logic  
 │   │   ├── Models/      # Tenant-related models  
 │   │   ├── Services/    # Tenant services (DB switching, creation)  
 │   │   ├── Middleware/  # Tenant detection middleware  
 │   │   ├── Listeners/   # Tenant event listeners  
 │   │   ├── Scopes/      # Query scopes (auto-filtering by tenant)  
 │   │   ├── Traits/      # Common tenant-related traits  
 │   │   ├── Providers/   # TenantServiceProvider  
 │   ├── RBAC/            # Role-based access control logic  
 │   │   ├── Models/      # Role, Permission models  
 │   │   ├── Services/    # Access control services  
 │   │   ├── Middleware/  # Role-based access middleware  
 │   │   ├── Policies/    # Authorization policies  
 │   │   ├── Traits/      # Role & permission traits  
```

📌 **Laravel autoload setup (`composer.json`):**
```json
"autoload": {
    "psr-4": {
        "Aaran\\": "aaran/"
    }
}
}
```
Then run:
```sh
  composer dump-autoload
```

---

## **3️⃣ Tenant Database Structure**
Each tenant gets its own database. We need a **central `tenants` table** to track them.

📌 **Central DB (`tenants` table, stored in the main system DB)**:

| id (UUID) | name  | domain  | db_name | db_host | db_user | db_pass  |
|-----------|------|--------|---------|--------|--------|--------|
| 1a2b3c   | ABC Corp | abc.aaran.com | tenant_abc | 127.0.0.1 | user1  | pass1  |
| 4d5e6f   | XYZ Ltd  | xyz.aaran.com | tenant_xyz | 127.0.0.1 | user2  | pass2  |

📌 **Each tenant database (`tenant_xxx` DB structure, per tenant)**:
- `users`
- `invoices`
- `subscriptions`
- (etc.)

---

## **4️⃣ Dynamic Tenant Connection (Middleware & Services)**
We need a **Tenant Switcher** to dynamically switch the database when a request comes.

### **📌 Middleware: Detect Tenant from Domain (`Aaran/Core/Tenant/Middleware/TenantMiddleware.php`)**

```php
namespace Aaran\Core\Tenant\Tests\Unit\Middleware;

use Closure;
use Aaran\Services\TenantService;
use Illuminate\Support\Facades\DB;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $hostname = $request->getHost();
        $tenant = TenantService::getTenantByDomain($hostname);

        if (!$tenant) {
            abort(404, "Tenant not found.");
        }

        // Switch the DB connection
        TenantService::switchToTenantDB($tenant);

        return $next($request);
    }
}
```
---

### **📌 Service: Switch to Tenant Database (`Aaran/Services/TenantService.php`)**
```php
namespace Aaran\Services;

use Illuminate\Support\Facades\DB;
use Aaran\Models\Tenant;

class TenantService
{
    public static function getTenantByDomain($domain)
    {
        return Tenant::where('domain', $domain)->first();
    }

    public static function switchToTenantDB($tenant)
    {
        config([
            'database.connections.tenant.database' => $tenant->db_name,
            'database.connections.tenant.host' => $tenant->db_host,
            'database.connections.tenant.username' => decrypt($tenant->db_user),
            'database.connections.tenant.password' => decrypt($tenant->db_pass),
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }
}
```
📌 **Database Config (`config/database.php`)**
```php
'connections' => [
    'tenant' => [
        'driver' => 'mysql',
        'host' => env('TENANT_DB_HOST', '127.0.0.1'),
        'database' => env('TENANT_DB_NAME', 'tenant_db'),
        'username' => env('TENANT_DB_USER', 'tenant_user'),
        'password' => env('TENANT_DB_PASS', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
],
```

---

## **5️⃣ Global Tenant Scope (Auto-Filter Queries by Tenant)**
To prevent cross-tenant data leaks, we **automatically filter queries** using **Global Scopes**.

📌 **Global Scope (`Aaran/Scopes/TenantScope.php`)**
```php
namespace Aaran\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if ($tenantId = session('tenant_id')) {
            $builder->where('tenant_id', $tenantId);
        }
    }
}
```
📌 **Apply to Tenant Models**
```php
class Invoice extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new TenantScope);
    }
}
```

✅ **Now, all queries automatically filter data by tenant!**

---

## **🚀 Final Execution Plan**
| Step | Task | Status |
|------|------|--------|
| 1️⃣  | Create `Aaran` folder structure ✅ | ✅ |
| 2️⃣  | Setup `tenants` table (central DB) ✅ | ✅ |
| 3️⃣  | Setup **Tenant Middleware** ✅ | ✅ |
| 4️⃣  | Implement **Tenant Service (DB switching)** ✅ | ✅ |
| 5️⃣  | Add **Global Scopes** for tenant filtering ✅ | ✅ |
| 🔟  | Start testing multi-tenancy 🚀 | 🔲 |

---

### **📌 Next Steps**
✅ Do you want **auto-creation of tenant DBs** when a new tenant registers?  
✅ Should we include **role-based access (RBAC) inside tenant DBs now**?


### **🔹 Folder Structure Decision**
Since we are designing **enterprise-grade multi-tenancy**, the best folder structure is:
```
/Aaran  
 ├── Core/  
 │   ├── Tenant/          # Multi-tenancy core logic  
 │   │   ├── Models/      # Tenant-related models  
 │   │   ├── Services/    # Tenant services (DB switching, creation)  
 │   │   ├── Middleware/  # Tenant detection middleware  
 │   │   ├── Listeners/   # Tenant event listeners  
 │   │   ├── Scopes/      # Query scopes (auto-filtering by tenant)  
 │   │   ├── Traits/      # Common tenant-related traits  
 │   │   ├── Providers/   # TenantServiceProvider  
 │   ├── RBAC/            # Role-based access control logic  
 │   │   ├── Models/      # Role, Permission models  
 │   │   ├── Services/    # Access control services  
 │   │   ├── Middleware/  # Role-based access middleware  
 │   │   ├── Policies/    # Authorization policies  
 │   │   ├── Traits/      # Role & permission traits  
```
📌 **Why `Aaran/Core/Tenant/`?**  
✔ Keeps **all tenant logic in one place**.  
✔ Allows future expansion (e.g., adding `Aaran/Core/Billing/`).  
✔ **Clear separation** between **multi-tenancy** and **RBAC**.

---

## **🔹 Step 2: Auto-Creation of Tenant Databases**
When a new tenant registers, we need to:  
✅ **Create a new database** for the tenant.  
✅ **Run migrations** inside that database.  
✅ **Assign a default admin role** for RBAC.

📌 **Service: Create Tenant DB (`Aaran/Core/Tenant/Services/TenantCreator.php`)**

```php
namespace Aaran\Core\Tenant\Tests\Unit\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Aaran\Core\Tenant\Tests\Unit\Models\Tenant;

class TenantCreator
{
    public static function create($name, $domain)
    {
        $dbName = 'tenant_' . strtolower(str_replace('.', '_', $domain));

        // Create tenant database
        DB::statement("CREATE DATABASE `$dbName`");

        // Store tenant details in central DB
        $tenant = Tenant::create([
            'name' => $name,
            'domain' => $domain,
            'db_name' => $dbName,
            'db_host' => config('database.connections.tenant.host'),
            'db_user' => encrypt(config('database.connections.tenant.username')),
            'db_pass' => encrypt(config('database.connections.tenant.password')),
        ]);

        // Run migrations inside tenant DB
        config(['database.connections.tenant.database' => $dbName]);
        DB::purge('tenant');
        DB::reconnect('tenant');
        Artisan::call('migrate', ['--database' => 'tenant', '--path' => 'database/migrations/tenant']);

        // Create default admin user & roles
        self::createDefaultRoles($tenant);

        return $tenant;
    }

    private static function createDefaultRoles($tenant)
    {
        DB::connection('tenant')->table('roles')->insert([
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'User', 'slug' => 'user'],
        ]);

        DB::connection('tenant')->table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@' . $tenant->domain,
            'password' => bcrypt('password'),
            'role' => 'super-admin',
        ]);
    }
}
```
✅ **Now, every time a new tenant registers, it automatically:**
- Creates a **new database** for the tenant.
- Runs **migrations** inside the tenant database.
- **Assigns default roles & an admin user**.

---

## **🚀 Next Steps**
| Step | Task | Status |
|------|------|--------|
| 1️⃣  | Confirm folder structure (`Aaran/Core/Tenant`) ✅ | ✅ |
| 2️⃣  | Implement **tenant auto-creation service** ✅ | ✅ |
| 3️⃣  | Setup **RBAC inside each tenant DB** ✅ | ✅ |
| 4️⃣  | Final testing 🚀 | 🔲 |

📌 **Shall we now build the full RBAC system (roles, permissions, middleware) inside the tenant databases?** 🚀
```
📌 **Register in `app/Http/Kernel.php`:**
```php
protected $middleware = [
    \Aaran\Core\Tenant\Middleware\TenantMiddleware::class,
];
```
