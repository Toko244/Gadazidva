# Localization Guide

## Overview

The Gadazidva application now supports **bilingual** functionality with **English (en)** and **Georgian (ka)** languages. All API response messages and validation errors are fully translated.

---

## Supported Languages

- **English** (en) - Default language
- **Georgian** (ka) - ქართული

---

## Language Files Structure

```
lang/
├── en/
│   ├── messages.php       # API response messages
│   ├── validation.php     # Validation error messages
│   ├── auth.php          # Authentication messages
│   └── passwords.php     # Password reset messages
└── ka/
    ├── messages.php       # API response messages (Georgian)
    ├── validation.php     # Validation error messages (Georgian)
    ├── auth.php          # Authentication messages (Georgian)
    └── passwords.php     # Password reset messages (Georgian)
```

---

## How to Switch Languages

### For API Clients

Send the `Accept-Language` header with your requests:

#### English (Default)
```bash
curl -H "Accept-Language: en" http://localhost:8000/api/service-posts
```

#### Georgian
```bash
curl -H "Accept-Language: ka" http://localhost:8000/api/service-posts
```

### Example with Authorization

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept-Language: ka" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }'
```

**Response in Georgian:**
```json
{
  "message": "ავტორიზაცია წარმატებულია",
  "user": {...},
  "token": "..."
}
```

---

## Translation Categories

### 1. API Response Messages (`messages.php`)

All success and error messages from API endpoints.

**English:**
```php
'service_post' => [
    'created' => 'Service post created successfully',
    'updated' => 'Service post updated successfully',
    'deleted' => 'Service post deleted successfully',
]
```

**Georgian:**
```php
'service_post' => [
    'created' => 'სერვისის განცხადება წარმატებით შეიქმნა',
    'updated' => 'სერვისის განცხადება წარმატებით განახლდა',
    'deleted' => 'სერვისის განცხადება წარმატებით წაიშალა',
]
```

### 2. Validation Messages (`validation.php`)

All form validation error messages.

**English:**
```php
'required' => 'The :attribute field is required.',
'email' => 'The :attribute field must be a valid email address.',
'min' => [
    'string' => 'The :attribute field must be at least :min characters.',
],
```

**Georgian:**
```php
'required' => ':attribute სავალდებულოა.',
'email' => ':attribute უნდა იყოს ვალიდური ელფოსტის მისამართი.',
'min' => [
    'string' => ':attribute უნდა იყოს მინიმუმ :min სიმბოლო.',
],
```

### 3. Authentication Messages (`auth.php`)

Login and authentication error messages.

### 4. Password Reset Messages (`passwords.php`)

Password reset related messages.

---

## Usage in Code

### In Controllers

Use the `__()` helper function:

```php
return response()->json([
    'message' => __('messages.service_post.created'),
    'data' => $post
], 201);
```

### In Form Requests

Laravel automatically uses `validation.php` translations. Custom attributes are defined in `validation.php`:

```php
'attributes' => [
    'email' => 'email',        // English
    'email' => 'ელფოსტა',      // Georgian
    'password' => 'password',  // English
    'password' => 'პაროლი',    // Georgian
]
```

---

## Testing Translations

### Test English Response
```bash
curl -H "Accept-Language: en" http://localhost:8000/api/service-posts
```

### Test Georgian Response
```bash
curl -H "Accept-Language: ka" http://localhost:8000/api/service-posts
```

### Test Validation Errors in Georgian
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept-Language: ka" \
  -d '{
    "email": "invalid-email"
  }'
```

**Expected Georgian Response:**
```json
{
  "message": "ვალიდაციის შეცდომა",
  "errors": {
    "name": ["სახელი სავალდებულოა"],
    "email": ["ელფოსტა უნდა იყოს ვალიდური ელფოსტის მისამართი"],
    "password": ["პაროლი სავალდებულოა"]
  }
}
```

---

## Adding New Translations

### 1. Add to English File

**lang/en/messages.php:**
```php
'new_feature' => [
    'created' => 'New feature created successfully',
],
```

### 2. Add Georgian Translation

**lang/ka/messages.php:**
```php
'new_feature' => [
    'created' => 'ახალი ფუნქცია წარმატებით შეიქმნა',
],
```

### 3. Use in Controller

```php
return response()->json([
    'message' => __('messages.new_feature.created')
]);
```

---

## Configuration

### Default Locale

Set in `.env`:
```env
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

### Available Locales

Configured in `config/app.php`:
```php
'available_locales' => ['en', 'ka'],
```

---

## Middleware

The `SetLocale` middleware automatically detects the `Accept-Language` header and sets the application locale accordingly.

**Location:** `app/Http/Middleware/SetLocale.php`

**Registration:** `bootstrap/app.php` (global middleware)

---

## Translation Keys Reference

### Authentication
- `messages.auth.register_success`
- `messages.auth.login_success`
- `messages.auth.logout_success`
- `messages.auth.invalid_credentials`

### Service Posts
- `messages.service_post.created`
- `messages.service_post.updated`
- `messages.service_post.deleted`
- `messages.service_post.not_found`
- `messages.service_post.unauthorized`

### Driver Profiles
- `messages.driver_profile.created`
- `messages.driver_profile.updated`
- `messages.driver_profile.deleted`
- `messages.driver_profile.not_found`
- `messages.driver_profile.unauthorized`
- `messages.driver_profile.already_exists`
- `messages.driver_profile.cost_calculated`

### Helper Posts
- `messages.helper_post.created`
- `messages.helper_post.updated`
- `messages.helper_post.deleted`
- `messages.helper_post.marked_filled`
- `messages.helper_post.marked_completed`
- `messages.helper_post.unauthorized`

### Assistant Profiles
- `messages.assistant_profile.created`
- `messages.assistant_profile.updated`
- `messages.assistant_profile.deleted`
- `messages.assistant_profile.not_found`
- `messages.assistant_profile.already_exists`
- `messages.assistant_profile.cost_calculated`

### Ratings
- `messages.rating.created`
- `messages.rating.already_rated`
- `messages.rating.cannot_rate_self`

### Messages
- `messages.message.sent`
- `messages.message.marked_read`
- `messages.message.unauthorized`

### Payments
- `messages.payment.created`
- `messages.payment.processed`
- `messages.payment.not_found`
- `messages.payment.unauthorized`
- `messages.payment.cannot_refund`

### Distance Calculator
- `messages.distance.calculated`
- `messages.distance.estimated`

---

## Best Practices

1. **Always use translation keys** instead of hardcoded strings
2. **Test both languages** when adding new messages
3. **Keep translations consistent** across modules
4. **Use descriptive keys** for easy maintenance
5. **Document new translation keys** in this guide

---

## Frontend Integration

### JavaScript/React Example

```javascript
// Add header to all API requests
axios.defaults.headers.common['Accept-Language'] = 'ka'; // or 'en'

// Or per request
axios.get('/api/service-posts', {
  headers: {
    'Accept-Language': 'ka'
  }
});
```

### Mobile App Example

```swift
// iOS Swift
var request = URLRequest(url: url)
request.setValue("ka", forHTTPHeaderField: "Accept-Language")
```

```kotlin
// Android Kotlin
val request = Request.Builder()
    .url(url)
    .addHeader("Accept-Language", "ka")
    .build()
```

---

## Troubleshooting

### Translations Not Working

1. **Check middleware is registered:**
   ```php
   // bootstrap/app.php
   $middleware->append(\App\Http\Middleware\SetLocale::class);
   ```

2. **Verify Accept-Language header is sent:**
   ```bash
   curl -v -H "Accept-Language: ka" http://localhost:8000/api/...
   ```

3. **Clear config cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

4. **Check translation file exists:**
   ```bash
   ls -la lang/ka/
   ```

### Fallback to English

If an invalid locale is provided or translation key doesn't exist, the app automatically falls back to English.

---

## Future Enhancements

- Add more languages (Russian, Turkish, etc.)
- Implement user-specific language preferences
- Add database-driven translations for dynamic content
- Create translation management UI in admin panel

---

## Statistics

- **2 Languages Supported:** English, Georgian
- **4 Translation Files per Language:** messages, validation, auth, passwords
- **60+ API Endpoints Translated**
- **100+ Validation Messages Translated**
- **All Controllers Updated:** 9 controllers with full translation support

---

✅ **Complete bilingual support successfully implemented!**
