# Aaran-BMS Multi-Tenant API Documentation

## Introduction
The **Aaran-BMS Multi-Tenant API** provides endpoints for managing tenants, authentication, and tenant-specific operations. This document outlines the API structure, authentication methods, and request/response formats.

---

## 1. Authentication
### **1.1 Tenant-Based Authentication**
Each tenant has its own authentication system using Laravel Sanctum.

#### **Login Request**
```http
POST /api/tenant/auth/login
```
##### **Request Body**
```json
{
  "email": "admin@tenant.com",
  "password": "password"
}
```
##### **Response**
```json
{
  "token": "eyJhbGciOiJIUzI1..."
}
```

#### **Logout Request**
```http
POST /api/tenant/auth/logout
```

---

## 2. Tenant Management
### **2.1 Create Tenant**
```http
POST /api/tenants
```
##### **Request Body**
```json
{
  "name": "Tenant One",
  "domain": "tenant1.example.com"
}
```
##### **Response**
```json
{
  "id": 1,
  "name": "Tenant One",
  "domain": "tenant1.example.com",
  "created_at": "2025-03-22T10:00:00Z"
}
```

### **2.2 Get Tenant Details**
```http
GET /api/tenants/{id}
```
##### **Response**
```json
{
  "id": 1,
  "name": "Tenant One",
  "domain": "tenant1.example.com",
  "created_at": "2025-03-22T10:00:00Z"
}
```

### **2.3 Update Tenant**
```http
PUT /api/tenants/{id}
```
##### **Request Body**
```json
{
  "name": "Updated Tenant Name"
}
```
##### **Response**
```json
{
  "id": 1,
  "name": "Updated Tenant Name",
  "domain": "tenant1.example.com",
  "updated_at": "2025-03-22T12:00:00Z"
}
```

### **2.4 Delete Tenant**
```http
DELETE /api/tenants/{id}
```
##### **Response**
```json
{
  "message": "Tenant deleted successfully."
}
```

---

## 3. User Management (Per Tenant)
### **3.1 Create User**
```http
POST /api/tenant/users
```
##### **Request Body**
```json
{
  "name": "John Doe",
  "email": "john@tenant.com",
  "password": "password123"
}
```
##### **Response**
```json
{
  "id": 10,
  "name": "John Doe",
  "email": "john@tenant.com",
  "created_at": "2025-03-22T10:00:00Z"
}
```

### **3.2 Get Users**
```http
GET /api/tenant/users
```
##### **Response**
```json
[
  {
    "id": 10,
    "name": "John Doe",
    "email": "john@tenant.com"
  },
  {
    "id": 11,
    "name": "Jane Smith",
    "email": "jane@tenant.com"
  }
]
```

### **3.3 Delete User**
```http
DELETE /api/tenant/users/{id}
```
##### **Response**
```json
{
  "message": "User deleted successfully."
}
```

---

## 4. Role & Permissions (Per Tenant)
### **4.1 Assign Role to User**
```http
POST /api/tenant/users/{id}/roles
```
##### **Request Body**
```json
{
  "role": "admin"
}
```
##### **Response**
```json
{
  "message": "Role assigned successfully."
}
```

### **4.2 Get User Roles**
```http
GET /api/tenant/users/{id}/roles
```
##### **Response**
```json
{
  "roles": ["admin", "editor"]
}
```

---

## Conclusion
The **Aaran-BMS Multi-Tenant API** provides a structured way to manage tenants, users, and roles efficiently. Following RESTful principles ensures clarity, scalability, and easy integration. 🚀
