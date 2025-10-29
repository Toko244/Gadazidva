# Gadazidva API Documentation

Complete API reference for the Gadazidva Transportation Service Platform.

## Base URL
```
http://localhost:8000/api
```

## Authentication
All protected endpoints require Bearer token authentication:
```
Authorization: Bearer {your_token}
```

---

## Table of Contents
1. [Authentication](#authentication-endpoints)
2. [Service Posts](#service-posts)
3. [Driver Profiles](#driver-profiles)
4. [Helper Posts](#helper-posts)
5. [Assistant Profiles](#assistant-profiles)
6. [Ratings](#ratings)
7. [Distance Calculator](#distance-calculator)
8. [Messaging](#messaging)
9. [Payments](#payments)

---

## Authentication Endpoints

### Register
**POST** `/register`

Register a new user with role assignment.

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password",
  "phone": "+995555123456",
  "city": "Tbilisi",
  "address": "123 Main St",
  "role": "user"
}
```

**Roles:** `user`, `driver`, `assistant`

**Response (201):**
```json
{
  "message": "User registered successfully",
  "user": {...},
  "token": "your_auth_token"
}
```

### Login
**POST** `/login`

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password"
}
```

**Response (200):**
```json
{
  "message": "Login successful",
  "user": {...},
  "token": "your_auth_token"
}
```

### Logout
**POST** `/logout` 🔒

Revoke current access token.

### Get Current User
**GET** `/me` 🔒

---

## Service Posts

### List Service Posts
**GET** `/service-posts`

Get all active service posts with optional filters.

**Query Parameters:**
- `origin_city` - Filter by origin city
- `destination_city` - Filter by destination city
- `cargo_type_id` - Filter by cargo type
- `loading_date_from` - Filter by start date
- `loading_date_to` - Filter by end date
- `per_page` - Items per page (default: 15)

**Example:**
```
GET /service-posts?origin_city=Tbilisi&destination_city=Batumi&cargo_type_id=1
```

### Get Single Service Post
**GET** `/service-posts/{id}`

### Create Service Post
**POST** `/service-posts` 🔒 (User role only)

**Request Body:**
```json
{
  "cargo_type_id": 1,
  "title": "Furniture delivery from Tbilisi to Batumi",
  "origin_address": "123 Main St",
  "origin_city": "Tbilisi",
  "origin_latitude": 41.7151,
  "origin_longitude": 44.8271,
  "destination_address": "456 Beach Rd",
  "destination_city": "Batumi",
  "destination_latitude": 41.6168,
  "destination_longitude": 41.6367,
  "loading_date": "2025-11-01 09:00:00",
  "cargo_weight": 500,
  "description": "2 sofas and 1 dining table",
  "contact_phone": "+995555123456",
  "contact_email": "user@example.com"
}
```

**With Images (multipart/form-data):**
Add `images[]` field with multiple image files.

### Update Service Post
**PUT** `/service-posts/{id}` 🔒 (Owner only)

### Delete Service Post
**DELETE** `/service-posts/{id}` 🔒 (Owner only)

### Get My Service Posts
**GET** `/my-service-posts` 🔒 (User role)

---

## Driver Profiles

### List Driver Profiles
**GET** `/driver-profiles`

Get all active and verified driver profiles.

**Query Parameters:**
- `vehicle_type_id` - Filter by vehicle type
- `city` - Filter by city
- `min_rating` - Minimum rating filter
- `max_rate` - Maximum rate per km
- `is_available` - Filter by availability

### Get Single Driver Profile
**GET** `/driver-profiles/{id}`

### Create Driver Profile
**POST** `/driver-profiles` 🔒 (Driver role only)

**Request Body:**
```json
{
  "vehicle_type_id": 1,
  "vehicle_make": "Toyota",
  "vehicle_model": "Hiace",
  "vehicle_year": 2020,
  "vehicle_plate_number": "TB-123-AB",
  "vehicle_color": "White",
  "vehicle_capacity": 1500,
  "bio": "Experienced driver with 10 years...",
  "base_rate_per_km": 2.5,
  "base_rate_fixed": 50
}
```

### Update Driver Profile
**PUT** `/driver-profiles/{id}` 🔒 (Owner only)

### Delete Driver Profile
**DELETE** `/driver-profiles/{id}` 🔒 (Owner only)

### Get My Driver Profile
**GET** `/my-driver-profile` 🔒 (Driver role)

### Calculate Trip Cost
**GET** `/driver-profiles/{id}/calculate-cost?distance=50`

Calculate estimated trip cost based on distance.

---

## Helper Posts

### List Helper Posts
**GET** `/helper-posts`

Get all active helper posts (visible to assistants).

**Query Parameters:**
- `location_city` - Filter by city
- `required_date_from` - Start date
- `required_date_to` - End date
- `min_rate` - Minimum offered rate
- `helpers_needed` - Number of helpers

### Get Single Helper Post
**GET** `/helper-posts/{id}`

### Create Helper Post
**POST** `/helper-posts` 🔒 (Driver role only)

**Request Body:**
```json
{
  "title": "Need 2 helpers for furniture loading",
  "description": "Loading furniture from 3rd floor apartment",
  "location_address": "789 Central Ave",
  "location_city": "Tbilisi",
  "location_latitude": 41.7151,
  "location_longitude": 44.8271,
  "required_date": "2025-11-05 14:00:00",
  "duration_hours": 3,
  "helpers_needed": 2,
  "offered_rate": 50,
  "contact_phone": "+995555123456",
  "requirements": "Ability to lift heavy items"
}
```

### Update Helper Post
**PUT** `/helper-posts/{id}` 🔒 (Owner only)

### Delete Helper Post
**DELETE** `/helper-posts/{id}` 🔒 (Owner only)

### Get My Helper Posts
**GET** `/my-helper-posts` 🔒 (Driver role)

### Mark as Filled
**POST** `/helper-posts/{id}/mark-filled` 🔒 (Owner only)

### Mark as Completed
**POST** `/helper-posts/{id}/mark-completed` 🔒 (Owner only)

---

## Assistant Profiles

### List Assistant Profiles
**GET** `/assistant-profiles`

**Query Parameters:**
- `city` - Filter by city
- `min_rating` - Minimum rating
- `max_hourly_rate` - Maximum hourly rate
- `has_own_tools` - Filter by tools (true/false)
- `is_available` - Filter by availability

### Get Single Assistant Profile
**GET** `/assistant-profiles/{id}`

### Create Assistant Profile
**POST** `/assistant-profiles` 🔒 (Assistant role only)

**Request Body:**
```json
{
  "bio": "Professional mover with 5 years experience",
  "skills": "Heavy lifting, Packing, Assembly, Disassembly",
  "years_of_experience": 5,
  "hourly_rate": 25,
  "has_own_tools": true
}
```

### Update Assistant Profile
**PUT** `/assistant-profiles/{id}` 🔒 (Owner only)

### Delete Assistant Profile
**DELETE** `/assistant-profiles/{id}` 🔒 (Owner only)

### Get My Assistant Profile
**GET** `/my-assistant-profile` 🔒 (Assistant role)

### Calculate Job Cost
**GET** `/assistant-profiles/{id}/calculate-cost?hours=4`

---

## Ratings

### Create Rating
**POST** `/ratings` 🔒

Rate a driver, assistant, or service post.

**Request Body:**
```json
{
  "rated_id": 5,
  "rateable_type": "App\\Models\\DriverProfile",
  "rateable_id": 3,
  "rating": 4.5,
  "comment": "Great driver, professional and on time!"
}
```

**Rating Values:** 1.0 to 5.0

**Rateable Types:**
- `App\Models\DriverProfile`
- `App\Models\AssistantProfile`
- `App\Models\ServicePost`

### Get Entity Ratings
**GET** `/ratings/entity?type=App\Models\DriverProfile&id=3` 🔒

Returns all ratings and average for an entity.

### Get My Given Ratings
**GET** `/my-given-ratings` 🔒

### Get My Received Ratings
**GET** `/my-received-ratings` 🔒

---

## Distance Calculator

### Calculate Distance
**POST** `/distance/calculate`

Calculate distance between two coordinates using Haversine formula.

**Request Body:**
```json
{
  "origin_lat": 41.7151,
  "origin_lon": 44.8271,
  "dest_lat": 41.6168,
  "dest_lon": 41.6367
}
```

**Response:**
```json
{
  "distance_km": 351.24,
  "distance_miles": 218.22
}
```

### Calculate Trip Estimate
**POST** `/distance/estimate`

Calculate distance and estimated cost.

**Request Body:**
```json
{
  "origin_lat": 41.7151,
  "origin_lon": 44.8271,
  "dest_lat": 41.6168,
  "dest_lon": 41.6367,
  "rate_per_km": 2.5,
  "fixed_rate": 50
}
```

**Response:**
```json
{
  "distance_km": 351.24,
  "rate_per_km": 2.5,
  "fixed_rate": 50,
  "distance_cost": 878.10,
  "total_cost": 928.10,
  "estimated_duration_minutes": 351
}
```

---

## Messaging

### Get Conversations
**GET** `/conversations` 🔒

Get all conversations for authenticated user.

### Create or Get Conversation
**POST** `/conversations` 🔒

**Request Body:**
```json
{
  "other_user_id": 5
}
```

### Get Messages
**GET** `/conversations/{conversation_id}/messages` 🔒

Returns paginated messages (50 per page).

### Send Message
**POST** `/messages` 🔒

**Request Body:**
```json
{
  "conversation_id": 1,
  "content": "Hello, is your service still available?"
}
```

### Mark Message as Read
**POST** `/messages/{id}/mark-read` 🔒

### Get Unread Count
**GET** `/messages/unread-count` 🔒

Returns total unread messages for authenticated user.

---

## Payments

### Create Payment
**POST** `/payments` 🔒

**Request Body:**
```json
{
  "payee_id": 5,
  "payable_type": "App\\Models\\ServicePost",
  "payable_id": 10,
  "amount": 500.00,
  "description": "Payment for furniture transport"
}
```

**Response (201):**
```json
{
  "message": "Payment created successfully",
  "data": {
    "id": 1,
    "transaction_id": "TXN-ABC123DEF456",
    "status": "pending",
    ...
  }
}
```

### Process Payment
**POST** `/payments/{id}/process` 🔒

**Request Body:**
```json
{
  "payment_method": "card",
  "payment_gateway": "stripe"
}
```

**Payment Methods:** `card`, `cash`, `bank_transfer`

### Get My Payments
**GET** `/my-payments?type=sent` 🔒

**Query Parameters:**
- `type` - Filter by type: `sent`, `received`, or null for all

### Calculate Platform Fee
**POST** `/payments/calculate-fee` 🔒

**Request Body:**
```json
{
  "amount": 500
}
```

**Response:**
```json
{
  "amount": 500,
  "platform_fee": 25,
  "total": 525
}
```

---

## Status Codes

- `200` - Success
- `201` - Resource created
- `400` - Bad request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not found
- `422` - Validation error
- `500` - Server error

## Error Response Format

```json
{
  "message": "Error description",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

---

## Rate Limiting

API requests are rate-limited to prevent abuse. Default limits apply per user.

## Pagination

List endpoints support pagination with the following meta structure:

```json
{
  "data": [...],
  "meta": {
    "total": 100,
    "current_page": 1,
    "last_page": 10,
    "per_page": 15
  }
}
```

---

🔒 = Requires authentication
