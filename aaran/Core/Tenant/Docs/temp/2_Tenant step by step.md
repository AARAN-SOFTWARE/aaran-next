Let's begin implementing the **Multi-Tenancy System** step by step, based on the plan.

---

## **🛠 Step 1: Create the Tenant Model & Migration**
This model will store tenant details like **name, domain, and database connection**.

### **🔹 Create Tenant Model**
Run the following command:

```sh
  php artisan make:model Core/Tenant/Models/Tenant -m
```

Now, update the **Tenant Model** (`Core/Tenant/Tenant.php`):

```php
namespace Aaran\Core\Tenant\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'domain', 'database', 'status'];

    public function users()
    {
        return $this->hasMany(\Aaran\Core\User\Models\User::class);
    }
}
```

### **🔹 Tenant Migration (`database/migrations/YYYY_MM_DD_create_tenants_table.php`)**
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('domain')->unique();
            $table->string('database')->unique();
            $table->tinyInteger('active_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tenants');
    }
};
```

Run migration:
```sh
  php artisan migrate
```

---

## **🛠 Step 2: Tenant Manager (Database Switching)**
This service will handle **switching databases dynamically**.

Create `Core/Tenant/TenantManager.php`:
```php
namespace Core\Tenant;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantManager
{
    protected static $tenant;

    public static function setTenant(Tenant $tenant)
    {
        static::$tenant = $tenant;
        static::setDatabaseConnection($tenant);
    }

    public static function getTenant()
    {
        return static::$tenant;
    }

    protected static function setDatabaseConnection(Tenant $tenant)
    {
        Config::set("database.connections.tenant", [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST', '127.0.0.1'),
            'database' => $tenant->database,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8mb4',
            'collation'=> 'utf8mb4_unicode_ci',
            'prefix'   => '',
            'strict'   => false,
            'engine'   => null,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }
}
```

---

## **🛠 Step 3: Middleware for Identifying Tenant**
This middleware will **detect tenants from subdomains or custom domains**.

Create a middleware:
```sh
  php artisan make:middleware TenantMiddleware
```

Now update `app/Http/Middleware/TenantMiddleware.php`:

```php
namespace App\Http\Middleware;

use Closure;
use Aaran\Core\Tenant\Tests\Unit\Models\Tenant;
use Aaran\Core\Tenant\Tests\Unit\Models\TenantManager;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $tenant = Tenant::where('domain', $host)->first();

        if ($tenant) {
            TenantManager::setTenant($tenant);
        } else {
            abort(404, "Tenant not found");
        }

        return $next($request);
    }
}
```

Register the middleware in `app/Http/Kernel.php`:

```php
protected $middleware = [
    // Other global middleware...
    \Aaran\Core\Tenant\Tests\Unit\Http\Middleware\TenantMiddleware::class,
];
```

---

## **🛠 Step 4: Tenant Creation Service**
Whenever a **new tenant registers**, we need to **create a database for them**.

Create `Core/Tenant/TenantDatabaseManager.php`:
```php
namespace Core\Tenant;

use Illuminate\Support\Facades\DB;

class TenantDatabaseManager
{
    public static function createDatabase(Tenant $tenant)
    {
        DB::statement("CREATE DATABASE `{$tenant->database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

        return true;
    }
}
```

Modify `Tenant` model to **trigger DB creation on saving**:

```php
use Aaran\Core\Tenant\Tests\Unit\Models\TenantDatabaseManager;

protected static function boot()
{
    parent::boot();

    static::created(function ($tenant) {
        TenantDatabaseManager::createDatabase($tenant);
    });
}
```

---

## **🛠 Step 5: Register a New Tenant**
Now we need a controller for **tenant registration**.

```sh
php artisan make:controller TenantController
```

Now update `app/Http/Controllers/TenantController.php`:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aaran\Core\Tenant\Tests\Unit\Models\Tenant;

class TenantController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|unique:tenants,name',
            'domain'  => 'required|unique:tenants,domain',
        ]);

        $database = 'tenant_' . strtolower(str_replace(' ', '_', $request->name));

        $tenant = Tenant::create([
            'name'    => $request->name,
            'domain'  => $request->domain,
            'database'=> $database,
            'status'  => 'active',
        ]);

        return response()->json(['message' => 'Tenant created successfully', 'tenant' => $tenant]);
    }
}
```

Register this route:
```php
Route::post('/tenants', [TenantController::class, 'store']);
```

---

## **🛠 Step 6: Tenant Database Migrations**
Since each tenant has its own database, we need a way to **run migrations for each tenant**.

Create a command:
```sh
php artisan make:command MigrateTenants
```

Now update `app/Console/Commands/MigrateTenants.php`:

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Aaran\Core\Tenant\Tests\Unit\Models\Tenant;
use Aaran\Core\Tenant\Tests\Unit\Models\TenantManager;
use Illuminate\Support\Facades\Artisan;

class MigrateTenants extends Command
{
    protected $signature = 'tenants:migrate';
    protected $description = 'Run migrations for all tenants';

    public function handle()
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            TenantManager::setTenant($tenant);
            Artisan::call('migrate', ['--database' => 'tenant', '--path' => 'database/migrations/tenant']);
        }

        $this->info('All tenant migrations completed!');
    }
}
```

Run tenant migrations:
```sh
php artisan tenants:migrate
```

---

## **🛠 Step 7: Tenant-Based Role & Permissions**
Since we **are not using Spatie**, we need a **custom RBAC system** inside each tenant's database.

Create **Role & Permission Models** inside `core/rbac`:
```sh
php artisan make:model Core/RBAC/Role -m
php artisan make:model Core/RBAC/Permission -m
```

### **🔹 Role Model**
```php
namespace Core\RBAC;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
```

### **🔹 Permission Model**
```php
namespace Core\RBAC;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];
}
```

---

## **✅ Next Steps**
- Implement **RBAC Middleware** for role-based access
- Create **Tenant Dashboard & API endpoints**
- Implement **auto-scaling & DB replication**

🚀 **Let me know if you need modifications before we move forward!**
