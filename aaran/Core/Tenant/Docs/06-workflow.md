Here's a high-level **workflow** for implementing multi-tenancy in your **Aaran-BMS** project using Laravel 12 and Livewire, structured under `Core/Tenant`:

---

### **Multi-Tenant Workflow (Step-by-Step)**

#### **1. Tenant Identification**
- Identify the tenant based on:
    - **Subdomain:** `tenant1.example.com`
    - **Domain:** `example1.com`
    - **Path-based:** `example.com/tenant1`
    - **Session/User:** Assign tenant dynamically after login
- Store tenant information in a middleware or service provider.

#### **2. Tenant Configuration & Bootstrapping**
- Load tenant-specific settings:
    - Database connection
    - Config overrides (app name, storage, etc.)
- Use a **TenantResolver** to determine the active tenant.
- Set database connection dynamically using `config(['database.connections.tenant' => [...]]);`

#### **3. Database Structure & Models**
- Choose between:
    - **Single Database, Tenant Column:** Add `tenant_id` to tables.
    - **Multiple Databases:** Each tenant gets a separate DB.
- Set up models and **global scopes** to filter data by `tenant_id` (if single DB).

#### **4. Middleware for Tenant Context**
- Create a `TenantMiddleware` to:
    - Check if a tenant exists.
    - Prevent access if the tenant is not valid.
- Apply middleware in `Kernel.php`.

#### **5. Tenant Registration & Onboarding**
- Provide a registration form to create a tenant:
    - Collect tenant name, domain, admin details.
    - Store tenant info in a **tenants** table.
- Create database/schema if using **multi-DB** approach.

#### **6. Routing & Request Handling**
- Modify routes based on tenant context.
- Use **middleware groups** to load tenant-specific controllers.

#### **7. Livewire Components for Tenant Management**
- Create dynamic Livewire components for:
    - Tenant dashboard
    - User management (inside tenant scope)
    - Subscription/billing system

#### **8. Centralized Tenant Management (Super Admin Panel)**
- Super Admin can:
    - View all tenants
    - Suspend/activate tenants
    - Manage tenant subscriptions

#### **9. Event & Hook System**
- Fire events when:
    - A tenant is created (`TenantCreated` event).
    - A tenant is deleted (`TenantDeleted` event).

#### **10. Tenant-Specific Storage & Configs**
- Store files per tenant (`storage/tenants/{tenant_id}/...`)
- Override `.env` values dynamically per tenant.

---

### **Flowchart Representation**
```plaintext
User Request  ---> Tenant Middleware ---> Identify Tenant 
                                         |
                                         v
                      Load Tenant Configuration & Database  
                                         |
                                         v
                  Route to Tenant-Specific Controller/Views
                                         |
                                         v
                   Tenant Operates with Isolated Data
```

This workflow ensures each tenant operates within their own space while maintaining centralized control. Do you need a **more detailed breakdown** of any section? 🚀
