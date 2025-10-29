# Gadazidva Platform - Complete Setup Guide

## Overview
This is a comprehensive Laravel 12 application with Repository Pattern, Service Layer, DTOs, and complete API architecture.

## Current Status ✅

All migrations have been run successfully and the database is ready!

- ✅ Laravel 12 installed
- ✅ All packages installed (Sanctum, Spatie Permission, Filament)
- ✅ Database configured and connected
- ✅ All migrations created and executed
- ✅ All models with relationships created
- ✅ Repository pattern implemented
- ✅ Service layer implemented
- ✅ DTOs created
- ✅ Form Requests created
- ✅ API Resources created
- ✅ Controllers created
- ✅ API routes configured
- ✅ Seeders created and run (roles, permissions, vehicle types, cargo types)

## Quick Start

### 1. Set up storage for image uploads
```bash
php artisan storage:link
```

### 2. Start the development server
```bash
php artisan serve
```

### 3. Test the API

The application is now running at `http://localhost:8000`

API endpoint: `http://localhost:8000/api`

### Example: Register a new user
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "user@test.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "user"
  }'
```

### Example: Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@test.com",
    "password": "password"
  }'
```

## Database Information

**Database Name**: gadazidva
**Connection**: MySQL via Homebrew on localhost

### Created Tables:
1. users - With custom fields (phone, avatar, city, address, is_available)
2. roles & permissions - Spatie Permission tables
3. personal_access_tokens - Laravel Sanctum
4. service_posts - Transportation requests
5. helper_posts - Driver helper requests
6. driver_profiles - Driver/vehicle information
7. assistant_profiles - Assistant information
8. vehicle_types - 6 types seeded
9. cargo_types - 8 types seeded
10. service_post_images - Image attachments
11. driver_profile_images - Vehicle photos

### Seeded Data:

**Roles:**
- user (can create service posts, view drivers)
- driver (can view service posts, create helper posts)
- assistant (can view helper posts)

**Vehicle Types:**
- Small Van
- Large Van
- Pickup Truck
- Box Truck
- Flatbed Truck
- Refrigerated Truck

**Cargo Types:**
- Furniture
- Electronics
- Food & Beverages
- Building Materials
- Household Items
- Documents & Parcels
- Machinery
- Other

## What's Implemented

### 1. Authentication System (✅ Complete)
- Register with role selection
- Login with token generation
- Logout
- Get authenticated user

**Files:**
- `app/Http/Controllers/Api/AuthController.php`
- `app/Http/Requests/RegisterRequest.php`
- `app/Http/Requests/LoginRequest.php`

### 2. Service Post Management (✅ Complete)
- Create service posts (users only)
- List service posts with filters
- View single post
- Update own posts
- Delete own posts
- Image upload support

**Files:**
- `app/Models/ServicePost.php`
- `app/Repositories/ServicePostRepository.php`
- `app/Services/ServicePostService.php`
- `app/DTOs/ServicePostDTO.php`
- `app/Http/Controllers/Api/ServicePostController.php`
- `app/Http/Requests/StoreServicePostRequest.php`
- `app/Http/Requests/UpdateServicePostRequest.php`
- `app/Http/Resources/ServicePostResource.php`

### 3. Architecture Patterns (✅ Complete)

**Repository Pattern:**
- Base interface: `app/Repositories/Contracts/RepositoryInterface.php`
- Base implementation: `app/Repositories/BaseRepository.php`
- Example: `app/Repositories/ServicePostRepository.php`

**Service Layer:**
- Base service: `app/Services/BaseService.php`
- Example: `app/Services/ServicePostService.php`

**DTOs:**
- `app/DTOs/ServicePostDTO.php`
- `app/DTOs/DriverProfileDTO.php`

## What You Need to Implement

### 1. Driver Profile Management
Create the following files following the ServicePost pattern:

```bash
# Controller
app/Http/Controllers/Api/DriverProfileController.php

# Repository
app/Repositories/DriverProfileRepository.php

# Service
app/Services/DriverProfileService.php

# Requests
app/Http/Requests/StoreDriverProfileRequest.php (already exists!)
app/Http/Requests/UpdateDriverProfileRequest.php

# Resource
app/Http/Resources/DriverProfileResource.php (already exists!)

# Add routes in routes/api.php
```

### 2. Helper Post Management
Similar structure as Driver Profiles

### 3. Assistant Profile Management
Similar structure as Driver Profiles

### 4. Filament Admin Panel
```bash
# Create Filament resources
php artisan make:filament-resource User
php artisan make:filament-resource ServicePost
php artisan make:filament-resource DriverProfile
php artisan make:filament-resource HelperPost

# Create admin user
php artisan make:filament-user
```

### 5. Additional Features
- Implement distance calculation service
- Add rating system
- Implement real-time notifications
- Add chat functionality
- Create API documentation with Scribe

## Testing the Application

### 1. Register Users with Different Roles

**Register a User:**
```bash
POST /api/register
{
  "name": "Regular User",
  "email": "user@gadazidva.ge",
  "password": "password",
  "password_confirmation": "password",
  "role": "user"
}
```

**Register a Driver:**
```bash
POST /api/register
{
  "name": "Driver Name",
  "email": "driver@gadazidva.ge",
  "password": "password",
  "password_confirmation": "password",
  "role": "driver"
}
```

**Register an Assistant:**
```bash
POST /api/register
{
  "name": "Assistant Name",
  "email": "assistant@gadazidva.ge",
  "password": "password",
  "password_confirmation": "password",
  "role": "assistant"
}
```

### 2. Create a Service Post

```bash
POST /api/service-posts
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "cargo_type_id": 1,
  "title": "Furniture Transport",
  "origin_address": "123 Rustaveli Ave",
  "origin_city": "Tbilisi",
  "destination_address": "456 Agmashenebeli St",
  "destination_city": "Batumi",
  "loading_date": "2025-11-15 10:00:00",
  "cargo_weight": 250.50,
  "description": "Need to transport furniture",
  "contact_phone": "+995555123456",
  "images[]": [file1, file2]
}
```

### 3. List Service Posts with Filters

```bash
GET /api/service-posts?origin_city=Tbilisi&cargo_type_id=1&per_page=10
```

## Troubleshooting

### Database Connection Issues
If you get database connection errors:
1. Ensure MySQL is running: `brew services list`
2. Start MySQL: `brew services start mysql`
3. Check credentials in `.env`

### Permission Issues
If migrations fail with permission errors:
```bash
sudo chmod -R 755 storage bootstrap/cache
```

### Clear Cache
If you make configuration changes:
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

## Project Structure Reference

```
gadazidva/
├── app/
│   ├── DTOs/                     # Data Transfer Objects
│   ├── Http/
│   │   ├── Controllers/Api/      # API Controllers
│   │   ├── Requests/             # Form Requests (Validation)
│   │   └── Resources/            # API Resources (Response formatting)
│   ├── Models/                   # Eloquent Models
│   ├── Repositories/             # Repository Pattern
│   └── Services/                 # Business Logic Layer
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── routes/
│   ├── api.php                   # API routes
│   └── web.php                   # Web routes
└── README.md                     # Main documentation
```

## Support & Documentation

- Laravel Documentation: https://laravel.com/docs
- Laravel Sanctum: https://laravel.com/docs/sanctum
- Spatie Permission: https://spatie.be/docs/laravel-permission
- Filament: https://filamentphp.com/docs

## Next Steps

1. ✅ All foundation is complete
2. Create Filament admin resources
3. Implement remaining controllers (Driver, Helper, Assistant)
4. Add comprehensive tests
5. Implement additional features (ratings, chat, notifications)
6. Deploy to production

---

**Note**: This is a production-ready foundation. All core architecture is in place. You can now extend it with additional features and controllers following the established patterns.
