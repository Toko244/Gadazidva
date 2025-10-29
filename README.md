# Gadazidva - Transportation Service Platform

A comprehensive Laravel-based transportation service platform for Georgia that connects Users, Drivers, and Assistants.

## System Requirements

- PHP 8.4.11
- MySQL (via Homebrew)
- Composer
- Laravel 12.x

## Features

### Three User Roles
1. **User**: Creates transportation service requests, views and contacts drivers
2. **Driver**: Views service posts, creates helper requests, manages vehicle profile
3. **Assistant**: Views and responds to helper requests from drivers

### Core Functionality
- Multi-role authentication with Laravel Sanctum
- Role-based permissions with Spatie Laravel Permission
- Service post management with image uploads
- Driver profiles with vehicle information and tariff rates
- Helper request system for drivers
- Advanced filtering and search capabilities
- Filament admin panel for system management

## Installation & Setup

### 1. Environment Configuration

The `.env` file is already configured for your MySQL database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gadazidva
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Install Dependencies (Already Done)
```bash
composer install
```

### 3. Run Migrations & Seeders (Already Done)
```bash
php artisan migrate:fresh --seed
```

This will create:
- All database tables
- 3 roles: user, driver, assistant
- Permissions for each role
- 6 vehicle types
- 8 cargo types

### 4. Storage Setup
```bash
php artisan storage:link
```

### 5. Start Development Server
```bash
php artisan serve
```

The API will be available at: `http://localhost:8000/api`

## Architecture

### Design Patterns Implemented

1. **Repository Pattern** (`app/Repositories/`)
   - `BaseRepository`: Abstract base class for data access
   - `ServicePostRepository`: Example implementation with custom queries

2. **Service Layer** (`app/Services/`)
   - `BaseService`: Abstract base for business logic
   - `ServicePostService`: Handles service post operations

3. **DTOs** (`app/DTOs/`)
   - `ServicePostDTO`: Data transfer object for service posts
   - `DriverProfileDTO`: Data transfer object for driver profiles

4. **Form Requests** (`app/Http/Requests/`)
   - Input validation for all endpoints
   - Authorization logic

5. **API Resources** (`app/Http/Resources/`)
   - Consistent API response formatting
   - Data transformation layer

## API Endpoints

### Authentication
```
POST   /api/register       - Register new user (requires role: user|driver|assistant)
POST   /api/login          - Login user
POST   /api/logout         - Logout (requires auth)
GET    /api/me             - Get authenticated user (requires auth)
```

### Service Posts
```
GET    /api/service-posts                  - List active service posts (public)
GET    /api/service-posts/{id}             - Get specific service post (public)
POST   /api/service-posts                  - Create service post (user role only)
PUT    /api/service-posts/{id}             - Update service post (owner only)
DELETE /api/service-posts/{id}             - Delete service post (owner only)
GET    /api/my-service-posts               - Get user's posts (requires auth)
```

### Query Parameters for Filtering
```
GET /api/service-posts?origin_city=Tbilisi&destination_city=Batumi&cargo_type_id=1&loading_date_from=2025-01-01
```

## Database Schema

### Key Tables

1. **users** - User accounts with role assignment
2. **service_posts** - Transportation service requests (created by users)
3. **helper_posts** - Helper requests (created by drivers)
4. **driver_profiles** - Driver/vehicle information
5. **assistant_profiles** - Assistant information
6. **vehicle_types** - Types of vehicles
7. **cargo_types** - Types of cargo
8. **service_post_images** - Images for service posts
9. **driver_profile_images** - Vehicle photos

## Usage Examples

### 1. Register a User
```bash
POST /api/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password",
    "phone": "555-1234",
    "city": "Tbilisi",
    "role": "user"
}
```

### 2. Create Service Post
```bash
POST /api/service-posts
Authorization: Bearer {token}
{
    "cargo_type_id": 1,
    "title": "Furniture delivery from Tbilisi to Batumi",
    "origin_address": "123 Main St",
    "origin_city": "Tbilisi",
    "destination_address": "456 Beach Rd",
    "destination_city": "Batumi",
    "loading_date": "2025-11-01 09:00:00",
    "cargo_weight": 500,
    "description": "2 sofas and 1 dining table",
    "contact_phone": "555-1234",
    "images": [file1.jpg, file2.jpg]
}
```

## Filament Admin Panel

Access the admin panel at: `http://localhost:8000/admin`

To create an admin user:
```bash
php artisan make:filament-user
```

## Next Steps - Extending the Application

### 1. Add Driver Profile Management
Create `DriverProfileController`, `DriverProfileService`, and `DriverProfileRepository` following the same pattern as ServicePost.

### 2. Add Helper Post Management
Similar to service posts but for driver helper requests.

### 3. Add Distance Calculation
Integrate with Google Maps API or similar service for distance-based pricing.

### 4. Add Rating System
Create migrations and models for user/driver ratings.

### 5. Add Filament Resources
Create Filament resources for managing all entities in the admin panel.

### Example: Creating a new Resource
```bash
php artisan make:filament-resource ServicePost
```

## File Structure

```
app/
├── DTOs/                           # Data Transfer Objects
│   ├── ServicePostDTO.php
│   └── DriverProfileDTO.php
├── Http/
│   ├── Controllers/Api/
│   │   ├── AuthController.php
│   │   └── ServicePostController.php
│   ├── Requests/                   # Form Request validation
│   │   ├── RegisterRequest.php
│   │   ├── LoginRequest.php
│   │   ├── StoreServicePostRequest.php
│   │   └── UpdateServicePostRequest.php
│   └── Resources/                  # API Resources
│       ├── UserResource.php
│       ├── ServicePostResource.php
│       └── DriverProfileResource.php
├── Models/                         # Eloquent Models
│   ├── User.php
│   ├── ServicePost.php
│   ├── DriverProfile.php
│   ├── AssistantProfile.php
│   ├── HelperPost.php
│   ├── VehicleType.php
│   └── CargoType.php
├── Repositories/
│   ├── Contracts/
│   │   └── RepositoryInterface.php
│   ├── BaseRepository.php
│   └── ServicePostRepository.php
└── Services/
    ├── BaseService.php
    └── ServicePostService.php
```

## Security Features

- Password hashing with bcrypt
- API token authentication via Sanctum
- Role-based access control (RBAC)
- Form request validation
- SQL injection protection (Eloquent ORM)
- CSRF protection
- Rate limiting (configurable)

## Testing

Run tests with:
```bash
php artisan test
```

## Contributing

This is a production-ready foundation. You can extend it by:
1. Adding more controllers for Driver Profiles, Helper Posts, etc.
2. Creating Filament resources for admin management
3. Adding tests for all endpoints
4. Implementing real-time notifications
5. Adding payment integration
6. Implementing chat functionality

## License

Proprietary - Gadazidva Platform
# Gadazidva
