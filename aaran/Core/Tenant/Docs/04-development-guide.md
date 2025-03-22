# Multi-Tenant Module Development Guide

### **1.1 Key Components**
- **Database**: Manages migrations and seeders for tenant-specific tables.
- **Http**: Contains controllers to handle tenant-based requests.
- **Models**: Defines Eloquent models with tenant-aware relationships.
- **Services**: Implements business logic for tenant operations.
- **Repositories**: Handles data access and abstraction for models.
- **Middleware**: Ensures tenant identification and database switching.
- **Routes**: Defines API and web routes for tenant interactions.

---

## 2. Tenant Identification
Each request must be linked to a specific tenant. The system supports:

✅ **Subdomain-based identification**: e.g., `tenant1.example.com`  
✅ **Path-based identification**: e.g., `example.com/tenant/1`  
✅ **Token-based identification**: Used in API requests.

**Middleware Example (TenantMiddleware.php):**
```php
public function handle($request, Closure $next)
{
    $tenant = Tenant::where('domain', $request->getHost())->first();
    if (!$tenant) {
        abort(404, 'Tenant not found');
    }
    
    app()->instance('tenant', $tenant);
    
    return $next($request);
}
```

---

## 3. Database Connection Handling
Each tenant operates with its own database connection, configured dynamically.

**Service Provider Example:**
```php
public function boot()
{
    if (app()->has('tenant')) {
        config(['database.connections.tenant' => [
            'driver'   => 'mysql',
            'host'     => app('tenant')->db_host,
            'database' => app('tenant')->db_name,
            'username' => app('tenant')->db_user,
            'password' => app('tenant')->db_password,
        ]]);
        DB::purge('tenant');
        DB::reconnect('tenant');
    }
}
```

---

## 4. Best Practices for Multi-Tenant Development
To ensure a **scalable, maintainable, and efficient** multi-tenant implementation, follow these best practices:

### **4.1 Database Design**
- **Use Separate Databases for Large Tenants**: If tenants have heavy workloads, use independent databases for better performance.
- **Schema-Based Isolation for Medium-Sized Deployments**: Keep all tenant schemas in a single database for easier maintenance.
- **Shared Database with Tenant Identifiers for Lightweight Deployments**: Add a `tenant_id` column to shared tables for multi-tenancy.
- **Optimize Indexing**: Ensure queries use indexes on `tenant_id` to improve lookup speed.

### **4.2 Efficient Middleware & Request Handling**
- **Lazy Load Tenant Context**: Instead of loading the tenant in every request, cache tenant configurations to reduce database queries.
- **Avoid Hardcoding Tenant References**: Always retrieve the current tenant dynamically to support flexible architecture.
- **Restrict Cross-Tenant Access**: Implement middleware to prevent unauthorized access to tenant-specific resources.

### **4.3 Service & Repository Pattern**
- **Keep Business Logic in Services**: Ensure that controllers remain lightweight by delegating logic to service classes.
- **Use Repositories for Data Access**: Keep database interactions separate from the business logic layer.
- **Implement Dependency Injection**: Inject repositories into services instead of creating new instances inside methods.

**Example:**
```php
class TenantRepository {
    public function findByDomain($domain) {
        return Tenant::where('domain', $domain)->first();
    }
}
```

```php
class TenantService {
    protected $tenantRepository;
    
    public function __construct(TenantRepository $tenantRepository) {
        $this->tenantRepository = $tenantRepository;
    }

    public function getTenantByDomain($domain) {
        return $this->tenantRepository->findByDomain($domain);
    }
}
```

### **4.4 API and Routing Best Practices**
- **Prefix API Routes with `/tenant`**: Helps differentiate tenant-based routes.
- **Use Middleware to Enforce Tenant Context**: Ensures that each request is processed within its assigned tenant scope.
- **Validate Requests at the Middleware Level**: Reduce duplicate validations inside controllers.

```php
Route::middleware(['tenant'])->group(function () {
    Route::get('/dashboard', [TenantController::class, 'dashboard']);
});
```

### **4.5 Caching & Performance Optimization**
- **Use Redis for Tenant Caching**: Store frequently accessed tenant configurations in Redis.
- **Optimize Queries**: Avoid `N+1` queries by eager loading relationships.
- **Queue Background Tasks**: Offload heavy tasks to Laravel queues to prevent slowing down tenant requests.

**Example: Caching Tenant Data**
```php
Cache::remember("tenant_{$tenantId}", 3600, function () use ($tenantId) {
    return Tenant::find($tenantId);
});
```

### **4.6 Logging & Monitoring**
- **Use Tenant-Specific Log Files**: Store logs per tenant to isolate debugging data.
- **Monitor Query Performance**: Enable Laravel Query Log to detect slow queries.
- **Set Up Alerts for Errors**: Implement logging services like Sentry to capture and report tenant-specific issues.

```php
Log::channel('tenant')->info("Tenant {$tenant->id} accessed dashboard");
```

---

## 5. Testing & Debugging
Run tests using the tenant-specific test suite:
```sh
php artisan test --testsuite=Tenant
```

Ensure tests cover:
- **Tenant Identification** (correct database/schema switching)
- **Permission & Access Control** (users can only access their tenant's data)
- **Performance Tests** (load tests to verify scaling)

---

## Conclusion
Following these best practices ensures that the **Aaran-BMS Multi-Tenant Module** remains scalable, secure, and easy to maintain. By structuring the architecture properly, optimizing database queries, and enforcing strict access control, developers can build a highly efficient multi-tenant SaaS solution. 🚀
