### **🚀 Tenant Structure**

```
🌍 Core/ 
 ├── 🏢 Tenant/
 │   ├── ⚙️ Config/               
 │   │   └── 📄 tenant.php           # Tenant configuration settings
 │   │ 
 │   ├── 🗄️ Database/
 │   │   ├── 🏭 Factories/
 │   │   │    └── 🏗️ TenantFactory.php  # Factory for generating test tenants
 │   │   ├── 📜 Migrations/
 │   │   │    └── 📜 2025_xx_xx_create_tenants_table.php  # Tenant DB schema
 │   │   └── 🌱 Seeders/
 │   │        └── 🌱 TenantSeeder.php  # Seeds default tenant data
 │   │         
 │   ├── 📚 Docs/  # Documentation for the Tenant module
 │   │ 
 │   ├── 🌐 Http/
 │   │   ├── 🎮 Controllers/
 │   │   │    └── 🏗️ TenantController.php  # Handles tenant-related requests
 │   │   ├── 🔒 Middleware/
 │   │   │    └── 🛡️ TenantMiddleware.php  # Middleware for tenant identification
 │   │
 │   ├── ⚡ Livewire/   # Livewire components for tenant-related features
 │   │   ├── 📂 Class/
 │   │   │    └── 🎛️ TenantList.php  # Handles Class Component for UI
 │   │   ├── 🖥️ Views/
 │   │        └── 📄 tenant-list.blade.php  # Blade view for tenant listing
 │   │
 │   ├── 🏗️ Models/
 │   │   └── 🏢 Tenant.php   # Tenant model storing metadata
 │   │
 │   ├── 🛠️ Providers/   # Service providers for tenant bootstrapping
 │   │   └── ⚙️ TenantServiceProvider.php
 │   │
 │   ├── 🌍 Routes/
 │   │   ├── 🔗 api.php  # API routes for tenants
 │   │   └── 🛤️ web.php  # Web routes for tenants
 │   │
 │   ├── ⚙️ Services/  # Business logic related to tenants
 │   │   └── 🛠️ TenantService.php
 │   │
 │   ├── 🧪 Tests/
 │   │   ├── 🏗️ Feature/
 │   │   │    └── 🧪 TenantFeatureTest.php
 │   │   ├── ⚙️ Unit/
 │   │   │    └── 🧪 TenantUnitTest.php
 │   │
 │   └── 🔄 Repositories/  # Optional: If using a repository pattern
 │        └── 🗄️ TenantRepository.php

```

---
