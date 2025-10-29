# Gadazidva - Quick Start Guide ⚡

## Status: ✅ READY TO USE

Your Laravel application is fully set up and running!

## What's Already Done

✅ Laravel 12 installed with latest packages
✅ MySQL database "gadazidva" connected
✅ All migrations run successfully (14 tables created)
✅ Seeders run (3 roles, 9 permissions, 6 vehicle types, 8 cargo types)
✅ Complete authentication system with Sanctum
✅ Service Post management (full CRUD with images)
✅ Repository Pattern, Service Layer, DTOs implemented
✅ API routes configured with role-based middleware

## Start Using Now

### 1. Link Storage (for image uploads)
```bash
php artisan storage:link
```

### 2. Start Server
```bash
php artisan serve
```

API is now available at: **http://localhost:8000/api**

### 3. Test API

**Register a User:**
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@gadazidva.ge",
    "password": "password",
    "password_confirmation": "password",
    "phone": "+995555123456",
    "city": "Tbilisi",
    "role": "user"
  }'
```

**Login:**
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@gadazidva.ge",
    "password": "password"
  }'
```

**Create Service Post:**
```bash
curl -X POST http://localhost:8000/api/service-posts \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "cargo_type_id": 1,
    "title": "Furniture delivery",
    "origin_address": "123 Rustaveli Ave",
    "origin_city": "Tbilisi",
    "destination_address": "456 Beach Rd",
    "destination_city": "Batumi",
    "loading_date": "2025-11-15 10:00:00",
    "cargo_weight": 250,
    "description": "2 sofas",
    "contact_phone": "+995555123456"
  }'
```

## Available API Endpoints

### Public
- `POST /api/register` - Register (user|driver|assistant)
- `POST /api/login` - Login
- `GET /api/service-posts` - List posts (with filters)
- `GET /api/service-posts/{id}` - View post

### Protected (requires token)
- `POST /api/logout` - Logout
- `GET /api/me` - Get user info
- `POST /api/service-posts` - Create post (user role only)
- `PUT /api/service-posts/{id}` - Update post (owner)
- `DELETE /api/service-posts/{id}` - Delete post (owner)
- `GET /api/my-service-posts` - User's posts

## Database

**Name:** gadazidva
**Tables:** 14 tables created
**Seeded data:**
- 3 Roles: user, driver, assistant
- 9 Permissions
- 6 Vehicle Types
- 8 Cargo Types

## What to Build Next

1. **Driver Profile Controller** - Following ServicePost pattern
2. **Helper Post Controller** - For driver assistant requests
3. **Assistant Profile Controller** - Assistant management
4. **Filament Admin Panel** - `php artisan make:filament-user`
5. **Distance Calculator** - Google Maps API integration
6. **Rating System** - User/Driver ratings
7. **Real-time Features** - Chat, notifications

## Key Files

**Architecture:**
- `app/Repositories/BaseRepository.php` - Repository pattern base
- `app/Services/BaseService.php` - Service layer base
- `app/DTOs/` - Data Transfer Objects

**Example Implementation:**
- `app/Repositories/ServicePostRepository.php`
- `app/Services/ServicePostService.php`
- `app/Http/Controllers/Api/ServicePostController.php`

**Models:** All in `app/Models/`
**API Routes:** `routes/api.php`
**Migrations:** `database/migrations/`

## Documentation

- `README.md` - Full documentation
- `SETUP_INSTRUCTIONS.md` - Detailed setup guide
- `QUICKSTART.md` - This file

## Need Help?

1. Check `README.md` for detailed docs
2. Check `SETUP_INSTRUCTIONS.md` for setup details
3. Run `php artisan route:list` to see all routes
4. Run `php artisan tinker` for database testing

---

**You're all set! Start building your transportation platform! 🚀**
