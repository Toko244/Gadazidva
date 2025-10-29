# Translation Quick Reference

## 🚀 Quick Start

### Switch Language via API
```bash
# English (default)
curl -H "Accept-Language: en" http://localhost:8000/api/...

# Georgian
curl -H "Accept-Language: ka" http://localhost:8000/api/...
```

---

## 📁 File Locations

```
lang/
├── en/           # English translations
│   ├── messages.php
│   ├── validation.php
│   ├── auth.php
│   └── passwords.php
└── ka/           # Georgian translations (ქართული)
    ├── messages.php
    ├── validation.php
    ├── auth.php
    └── passwords.php
```

---

## 🔑 Common Translation Keys

### Authentication
```php
__('messages.auth.register_success')      // User registered successfully
__('messages.auth.login_success')         // Login successful
__('messages.auth.logout_success')        // Logged out successfully
__('messages.auth.invalid_credentials')   // Invalid credentials
```

### CRUD Operations
```php
__('messages.{module}.created')       // Created successfully
__('messages.{module}.updated')       // Updated successfully
__('messages.{module}.deleted')       // Deleted successfully
__('messages.{module}.not_found')     // Not found
__('messages.{module}.unauthorized')  // Unauthorized
```

**Modules:** `service_post`, `driver_profile`, `helper_post`, `assistant_profile`, `rating`, `message`, `payment`

---

## 💻 Usage in Code

### Controller Example
```php
// ❌ Before
return response()->json(['message' => 'Login successful']);

// ✅ After
return response()->json(['message' => __('messages.auth.login_success')]);
```

### Validation (Automatic)
```php
// Form Requests automatically use validation.php translations
// No changes needed - just works!
```

---

## 🧪 Testing

```bash
# Test English
php artisan tinker --execute="echo __('messages.auth.login_success');"
# Output: Login successful

# Test Georgian
php artisan tinker --execute="App::setLocale('ka'); echo __('messages.auth.login_success');"
# Output: ავტორიზაცია წარმატებულია
```

---

## 🌐 Client Integration

### JavaScript/Axios
```javascript
axios.defaults.headers.common['Accept-Language'] = 'ka';
```

### Fetch API
```javascript
fetch(url, {
  headers: { 'Accept-Language': 'ka' }
})
```

### iOS Swift
```swift
request.setValue("ka", forHTTPHeaderField: "Accept-Language")
```

### Android Kotlin
```kotlin
.addHeader("Accept-Language", "ka")
```

---

## 📦 What's Translated

✅ All API response messages (60+ endpoints)
✅ All validation errors (90+ rules)
✅ Authentication messages
✅ Password reset messages
✅ Custom field names (40+ fields)

---

## 🛠️ Configuration

**Default Locale:** Set in `.env`
```env
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

**Available Locales:** `config/app.php`
```php
'available_locales' => ['en', 'ka']
```

---

## 📚 Full Documentation

- **Usage Guide:** `LOCALIZATION_GUIDE.md`
- **Implementation Details:** `LOCALIZATION_IMPLEMENTATION.md`
- **API Documentation:** `API_DOCUMENTATION.md`

---

## 🎯 Key Benefits

- ✅ Bilingual support (English & Georgian)
- ✅ Automatic language detection
- ✅ 100% API coverage
- ✅ Production-ready
- ✅ Easy to extend

---

**Need help?** Check `LOCALIZATION_GUIDE.md` for detailed instructions!
