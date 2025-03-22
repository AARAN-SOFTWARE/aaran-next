# Getting Started (Multi-Tenant Module)

## Introduction
The **Aaran-BMS Multi-Tenant Module** is designed to support multiple tenants with isolated data while sharing the same codebase. It enables dynamic database switching, tenant-specific configurations, and flexible middleware handling. This module ensures scalability and efficiency for businesses managing multiple clients or entities within a single application.

## Pros and Cons
### Pros
✅ **Scalability** – Easily add new tenants without modifying the core system.  
✅ **Data Isolation** – Each tenant has its own database or schema, ensuring data security.  
✅ **Centralized Codebase** – Maintain a single application while serving multiple clients.  
✅ **Customizable** – Tenants can have unique configurations, themes, or settings.

### Cons
⚠️ **Complexity** – Requires careful database connection handling and middleware setup.  
⚠️ **Resource Overhead** – Each tenant’s database may require separate indexing and caching strategies.  
⚠️ **Migration Handling** – Schema updates must be applied across all tenant databases.

## Multi-Tenant Architecture
The module follows a **clean architecture** approach, ensuring modularity and maintainability.

### **1. Folder Structure**
```
/Core/Tenant
│── Database
│   ├── Migrations
│   ├── Seeders
│── Http
│   ├── Controllers
│── Models
│── Services
│── Repositories
│── Middleware
│── Routes
```

### **2. Key Components**
- **Database Switching**: Uses middleware to determine and connect to the appropriate tenant database.
- **Service & Repository Pattern**: Business logic is handled separately from data access for maintainability.
- **Tenant Identification**: Tenants are identified based on subdomains (e.g., `tenant1.example.com`).
- **Configurable Middleware**: Each request is processed with tenant-specific context.
- **Cache Optimization**: Implements Redis-based caching to enhance performance across tenants.

## Advanced Multi-Tenant Architecture
The system supports **three multi-tenancy strategies**, allowing flexibility based on use case:

1️⃣ **Database Per Tenant** – Each tenant has a separate database, ensuring maximum isolation.  
2️⃣ **Schema Per Tenant** – Uses a single database but isolates tenants via unique schemas.  
3️⃣ **Shared Database with Tenant Identifiers** – A single database with a `tenant_id` column in shared tables.

### **Implementation Overview**
- **Service Providers**: Registers tenant configurations dynamically.
- **Custom Tenant Middleware**: Ensures correct database connection per request.
- **Event-Driven Tenant Creation**: Automatically configures new tenants upon registration.
- **Role-Based Access Control (RBAC)**: Supports tenant-specific user roles and permissions.

---
This clean multi-tenant architecture ensures a robust and scalable solution within Aaran-BMS. 🚀
