# Postman Collection Guide

## 📦 Files Overview

The Gadazidva API Postman collection includes:

1. **`Gadazidva_API.postman_collection.json`** - Complete API collection with all endpoints
2. **`Gadazidva_Environment.postman_environment.json`** - Local development environment
3. **`Gadazidva_Production_Environment.postman_environment.json`** - Production environment

---

## 🚀 Quick Start

### Step 1: Import Collection

1. Open Postman
2. Click **Import** button (top left)
3. Drag and drop `Gadazidva_API.postman_collection.json` or click **Upload Files**
4. Collection will appear in your workspace

### Step 2: Import Environment

1. Click **Import** again
2. Import `Gadazidva_Environment.postman_environment.json` for local development
3. Or import `Gadazidva_Production_Environment.postman_environment.json` for production
4. Select the environment from the dropdown in top right corner

### Step 3: Start Testing

1. Go to **Authentication** → **Login**
2. Click **Send**
3. Token will be automatically saved to environment
4. All protected endpoints will now work

---

## 📁 Collection Structure

```
Gadazidva API Collection
├── Authentication (4 requests)
│   ├── Register
│   ├── Login
│   ├── Get Current User
│   └── Logout
├── Service Posts (6 requests)
│   ├── List Service Posts
│   ├── Get Single Service Post
│   ├── Create Service Post
│   ├── Update Service Post
│   ├── Delete Service Post
│   └── Get My Service Posts
├── Driver Profiles (8 requests)
│   ├── List Driver Profiles
│   ├── Get Single Driver Profile
│   ├── Create Driver Profile
│   ├── Update Driver Profile
│   ├── Delete Driver Profile
│   ├── Get My Driver Profile
│   └── Calculate Trip Cost
├── Helper Posts (8 requests)
│   ├── List Helper Posts
│   ├── Get Single Helper Post
│   ├── Create Helper Post
│   ├── Update Helper Post
│   ├── Delete Helper Post
│   ├── Get My Helper Posts
│   ├── Mark Helper Post as Filled
│   └── Mark Helper Post as Completed
├── Assistant Profiles (8 requests)
│   ├── List Assistant Profiles
│   ├── Get Single Assistant Profile
│   ├── Create Assistant Profile
│   ├── Update Assistant Profile
│   ├── Delete Assistant Profile
│   ├── Get My Assistant Profile
│   └── Calculate Job Cost
├── Ratings (4 requests)
│   ├── Create Rating
│   ├── Get Entity Ratings
│   ├── Get My Given Ratings
│   └── Get My Received Ratings
├── Distance Calculator (2 requests)
│   ├── Calculate Distance
│   └── Calculate Trip Estimate
├── Messaging (6 requests)
│   ├── Get My Conversations
│   ├── Create or Get Conversation
│   ├── Get Conversation Messages
│   ├── Send Message
│   ├── Mark Message as Read
│   └── Get Unread Messages Count
└── Payments (4 requests)
    ├── Create Payment
    ├── Process Payment
    ├── Get My Payments
    └── Calculate Platform Fee
```

**Total: 50 API Requests**

---

## 🔐 Authentication

### Automatic Token Management

The Login request includes a **test script** that automatically saves the authentication token:

```javascript
if (pm.response.code === 200) {
    var jsonData = pm.response.json();
    pm.environment.set("auth_token", jsonData.token);
}
```

After logging in, all protected endpoints will automatically use this token via:
```
Authorization: Bearer {{auth_token}}
```

### Manual Token Setup

If you already have a token:

1. Click the **Environment** dropdown (top right)
2. Click the **eye icon** next to your environment
3. Edit `auth_token` variable
4. Paste your token
5. Click **Save**

---

## 🌐 Language Support

### Switch Between English and Georgian

Each request includes an `Accept-Language` header. Change it to:

- **English:** `en`
- **Georgian:** `ka`

#### Example:

```
Accept-Language: ka
```

Response will be in Georgian:
```json
{
  "message": "სერვისის განცხადება წარმატებით შეიქმნა"
}
```

---

## 🛠️ Environment Variables

### Local Environment

```json
{
  "base_url": "http://localhost:8000",
  "auth_token": "",
  "language": "en"
}
```

### Production Environment

```json
{
  "base_url": "https://api.gadazidva.ge",
  "auth_token": "",
  "language": "en"
}
```

### Using Variables in Requests

Variables are referenced with double curly braces:
```
{{base_url}}/api/service-posts
{{auth_token}}
```

---

## 📝 Common Workflows

### Workflow 1: Create Service Post

1. **Login** → Get token (automatic)
2. **Service Posts** → **Create Service Post** → Send
3. **Service Posts** → **Get My Service Posts** → Verify creation

### Workflow 2: Rate a Driver

1. **Login** → Get token
2. **Driver Profiles** → **List Driver Profiles** → Find driver
3. **Ratings** → **Create Rating** → Rate driver
4. **Ratings** → **Get My Given Ratings** → Verify

### Workflow 3: Send Messages

1. **Login** → Get token
2. **Messaging** → **Create or Get Conversation** → Start conversation
3. **Messaging** → **Send Message** → Send message
4. **Messaging** → **Get Conversation Messages** → View history

### Workflow 4: Calculate Trip Cost

1. **Distance Calculator** → **Calculate Distance** → Get distance
2. **Driver Profiles** → **Calculate Trip Cost** → Get cost estimate
3. **Service Posts** → **Create Service Post** → Post service

---

## 🎯 Testing Scenarios

### Test User Registration & Role Assignment

```json
POST /api/register
{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "+995555123456",
  "city": "Tbilisi",
  "address": "123 Test St",
  "role": "driver"  // Change to: user, driver, assistant
}
```

### Test Filters

**Service Posts with Filters:**
```
GET /api/service-posts?origin_city=Tbilisi&destination_city=Batumi&cargo_type_id=1
```

**Driver Profiles with Filters:**
```
GET /api/driver-profiles?city=Tbilisi&min_rating=4&is_available=1
```

**Helper Posts with Filters:**
```
GET /api/helper-posts?location_city=Tbilisi&helpers_needed=2
```

---

## 🔍 Request Examples

### Creating a Driver Profile

```json
POST /api/driver-profiles
Authorization: Bearer {{auth_token}}
Accept-Language: en

{
  "vehicle_type_id": 1,
  "vehicle_make": "Toyota",
  "vehicle_model": "Hiace",
  "vehicle_year": 2020,
  "vehicle_plate_number": "TB-123-AB",
  "vehicle_color": "White",
  "vehicle_capacity": 1500,
  "bio": "Experienced driver with 10 years in transportation",
  "base_rate_per_km": 2.5,
  "base_rate_fixed": 50
}
```

### Creating a Rating

```json
POST /api/ratings
Authorization: Bearer {{auth_token}}

{
  "rated_id": 5,
  "rateable_type": "App\\Models\\DriverProfile",
  "rateable_id": 3,
  "rating": 4.5,
  "comment": "Great driver, professional and on time!"
}
```

### Processing a Payment

```json
POST /api/payments/1/process
Authorization: Bearer {{auth_token}}

{
  "payment_method": "card",
  "payment_gateway": "stripe"
}
```

---

## 🧪 Testing Tips

### 1. Use Collection Runner

1. Click on collection name
2. Click **Run** button
3. Select requests to run
4. Click **Run Gadazidva API**
5. View results

### 2. Use Variables for Test Data

Create environment variables for test data:
```
test_user_email = test@example.com
test_password = password123
```

### 3. Write Tests

Add tests to requests:

```javascript
// Check status code
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

// Check response structure
pm.test("Response has data", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('data');
});
```

### 4. Use Pre-request Scripts

Add pre-request scripts to generate dynamic data:

```javascript
// Generate unique email
pm.environment.set("random_email", `user${Date.now()}@example.com`);

// Generate timestamp
pm.environment.set("timestamp", new Date().toISOString());
```

---

## 📊 Response Examples

### Successful Response (English)

```json
{
  "message": "Service post created successfully",
  "data": {
    "id": 1,
    "title": "Furniture delivery",
    "origin_city": "Tbilisi",
    "destination_city": "Batumi"
  }
}
```

### Successful Response (Georgian)

```json
{
  "message": "სერვისის განცხადება წარმატებით შეიქმნა",
  "data": {
    "id": 1,
    "title": "Furniture delivery",
    "origin_city": "Tbilisi",
    "destination_city": "Batumi"
  }
}
```

### Validation Error (Georgian)

```json
{
  "message": "ვალიდაციის შეცდომა",
  "errors": {
    "email": ["ელფოსტა სავალდებულოა"],
    "password": ["პაროლი უნდა იყოს მინიმუმ 8 სიმბოლო"]
  }
}
```

---

## 🚨 Troubleshooting

### Issue: "Unauthorized" Error

**Solution:**
1. Make sure you're logged in
2. Check `auth_token` variable is set
3. Verify token hasn't expired
4. Re-login if necessary

### Issue: Variables Not Working

**Solution:**
1. Ensure environment is selected (top right dropdown)
2. Check variable spelling: `{{base_url}}` not `{{baseUrl}}`
3. Click environment eye icon to verify values

### Issue: 404 Not Found

**Solution:**
1. Verify `base_url` is correct
2. Check Laravel server is running: `php artisan serve`
3. Verify route exists in API documentation

### Issue: Validation Errors

**Solution:**
1. Check request body format matches examples
2. Verify all required fields are included
3. Check data types (numbers vs strings)
4. Review API documentation for field requirements

---

## 🎓 Advanced Features

### 1. Mock Servers

Create mock server from collection:
1. Click collection
2. Click **Mocks** tab
3. Create mock server
4. Use mock URL for frontend development

### 2. API Documentation

Generate documentation:
1. Click collection
2. Click **View documentation**
3. Click **Publish**
4. Share documentation URL

### 3. Newman (CLI Runner)

Run collection via command line:

```bash
# Install Newman
npm install -g newman

# Run collection
newman run Gadazidva_API.postman_collection.json \
  -e Gadazidva_Environment.postman_environment.json

# Generate HTML report
newman run Gadazidva_API.postman_collection.json \
  -e Gadazidva_Environment.postman_environment.json \
  -r html
```

### 4. CI/CD Integration

Integrate with GitHub Actions:

```yaml
- name: Run Postman Collection
  run: |
    npm install -g newman
    newman run collection.json -e environment.json
```

---

## 📱 Mobile App Testing

### iOS

Save environment with actual device/emulator IP:
```json
{
  "base_url": "http://192.168.1.100:8000"
}
```

### Android

Use special localhost:
```json
{
  "base_url": "http://10.0.2.2:8000"
}
```

---

## 🔄 Updating the Collection

### Export Updated Collection

1. Right-click collection
2. Click **Export**
3. Select **Collection v2.1**
4. Save file
5. Commit to version control

### Share with Team

1. Upload to workspace
2. Or share JSON file
3. Or publish documentation
4. Or create Team workspace in Postman

---

## 📚 Additional Resources

- **API Documentation:** `API_DOCUMENTATION.md`
- **Localization Guide:** `LOCALIZATION_GUIDE.md`
- **Implementation Summary:** `IMPLEMENTATION_SUMMARY.md`
- **Postman Learning:** https://learning.postman.com/

---

## ✅ Collection Statistics

- **Total Folders:** 9
- **Total Requests:** 50
- **Public Endpoints:** 15
- **Protected Endpoints:** 35
- **Languages Supported:** 2 (English, Georgian)
- **Environment Variables:** 3 per environment

---

## 🎉 You're Ready!

The collection is production-ready and includes:

✅ All 50 API endpoints
✅ Automatic authentication
✅ Bilingual support
✅ Example requests with proper data
✅ Environment variables
✅ Detailed descriptions
✅ Proper folder organization

**Happy Testing!** 🚀
