# Gadazidva Postman Collection

## 📦 Package Contents

This package includes everything you need to test the Gadazidva API:

### Collection Files

1. **`Gadazidva_API.postman_collection.json`** (38 KB)
   - Complete API collection
   - 50 requests across 9 modules
   - Pre-configured examples
   - Automatic token management

2. **`Gadazidva_Environment.postman_environment.json`** (410 bytes)
   - Local development environment
   - Base URL: `http://localhost:8000`

3. **`Gadazidva_Production_Environment.postman_environment.json`** (429 bytes)
   - Production environment
   - Base URL: `https://api.gadazidva.ge`

### Documentation Files

4. **`POSTMAN_COLLECTION_GUIDE.md`** (12 KB)
   - Complete usage guide
   - Testing workflows
   - Advanced features
   - Troubleshooting

5. **`POSTMAN_QUICK_START.md`** (2.4 KB)
   - Quick setup instructions
   - Common actions
   - Quick reference

---

## 🚀 Quick Import Instructions

### Option 1: Drag & Drop (Easiest)

1. Open Postman
2. Drag `Gadazidva_API.postman_collection.json` into Postman window
3. Drag `Gadazidva_Environment.postman_environment.json` into Postman window
4. Select "Gadazidva Local" from environment dropdown
5. Start testing!

### Option 2: Import Button

1. Open Postman
2. Click **Import** button (top left)
3. Click **Upload Files**
4. Select all 3 JSON files
5. Click **Import**
6. Select environment from dropdown

---

## 📊 Collection Overview

### Statistics

| Metric | Value |
|--------|-------|
| **Total Endpoints** | 50 |
| **Folders** | 9 |
| **Public Endpoints** | 15 |
| **Protected Endpoints** | 35 |
| **Languages Supported** | 2 (EN, KA) |
| **File Size** | 38 KB |

### Module Breakdown

| Module | Requests | Description |
|--------|----------|-------------|
| Authentication | 4 | Register, Login, Logout, Get User |
| Service Posts | 6 | Cargo transport service posts |
| Driver Profiles | 8 | Driver management & cost calculation |
| Helper Posts | 8 | Helper/assistant job posts |
| Assistant Profiles | 8 | Assistant management & pricing |
| Ratings | 4 | Rating system for all entities |
| Distance Calculator | 2 | Distance & cost estimation |
| Messaging | 6 | In-app messaging system |
| Payments | 4 | Payment processing & tracking |

---

## 🔑 Key Features

### ✅ Automatic Authentication
- Login request auto-saves token
- All protected endpoints use saved token
- No manual token copying needed

### ✅ Bilingual Support
- Switch between English and Georgian
- Change `Accept-Language` header: `en` or `ka`
- All responses translated automatically

### ✅ Environment Variables
```
{{base_url}}    - API base URL
{{auth_token}}  - Authentication token (auto-filled)
{{language}}    - Preferred language
```

### ✅ Pre-filled Examples
- Every request includes example data
- Ready to send without modifications
- Realistic test data

### ✅ Comprehensive Documentation
- Detailed descriptions for each request
- Parameter explanations
- Response examples

---

## 🎯 Getting Started

### Step 1: Import Everything

Import all files into Postman:
- Collection JSON
- Local environment JSON
- (Optional) Production environment JSON

### Step 2: Select Environment

Top right corner → Select **"Gadazidva Local"**

### Step 3: Make Your First Request

```
1. Authentication → Login → Send
   ✅ Token automatically saved

2. Service Posts → List Service Posts → Send
   ✅ View all service posts

3. Driver Profiles → List Driver Profiles → Send
   ✅ View all driver profiles
```

---

## 🌐 Testing Bilingual Responses

### English Response (default)
```
Accept-Language: en

Response:
{
  "message": "Login successful",
  "user": {...},
  "token": "..."
}
```

### Georgian Response
```
Accept-Language: ka

Response:
{
  "message": "ავტორიზაცია წარმატებულია",
  "user": {...},
  "token": "..."
}
```

---

## 📝 Common Testing Workflows

### Workflow 1: Complete User Journey

```
1. Register new user (role: user)
2. Login to get token
3. Create service post
4. List service posts
5. View my posts
6. Update service post
7. Delete service post
```

### Workflow 2: Driver Testing

```
1. Register as driver (role: driver)
2. Login to get token
3. Create driver profile
4. Create helper post
5. Calculate trip cost
6. Mark helper post as filled
```

### Workflow 3: Rating & Messaging

```
1. Login as user
2. Find a driver
3. Send message to driver
4. Create conversation
5. Rate the driver
6. View my given ratings
```

---

## 🔧 Environment Configuration

### Local Development

```json
{
  "base_url": "http://localhost:8000",
  "auth_token": "",
  "language": "en"
}
```

**Requirements:**
- Laravel app running: `php artisan serve`
- Database configured and migrated
- Seeders run (optional)

### Production

```json
{
  "base_url": "https://api.gadazidva.ge",
  "auth_token": "",
  "language": "en"
}
```

**Requirements:**
- Production server configured
- SSL certificate installed
- Database connected

---

## 🧪 Testing Tips

### 1. Use Collection Runner

Run all requests sequentially:
1. Click collection name
2. Click **Run**
3. Select requests to run
4. Click **Run Gadazidva API**

### 2. Save Responses as Examples

1. Send request
2. Click **Save Response**
3. Click **Save as example**
4. Name your example

### 3. Use Tests Tab

Add automated tests:
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response has data", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('data');
});
```

### 4. Monitor API

1. Click **Monitors** tab
2. Create new monitor
3. Schedule: Every 5 minutes
4. Get alerts on failures

---

## 🚨 Troubleshooting

### Problem: Unauthorized (401)

**Cause:** Missing or expired token

**Solution:**
1. Go to Authentication → Login
2. Click Send
3. Token will auto-save
4. Try your request again

### Problem: Variables Not Working

**Cause:** Environment not selected

**Solution:**
1. Check top-right corner
2. Select "Gadazidva Local" from dropdown
3. Click eye icon to verify variables

### Problem: Connection Refused

**Cause:** Laravel server not running

**Solution:**
```bash
# Start Laravel server
php artisan serve

# Or specify port
php artisan serve --port=8000
```

### Problem: 404 Not Found

**Cause:** Incorrect base URL or route

**Solution:**
1. Verify `base_url` in environment
2. Check Laravel server is running
3. Verify routes: `php artisan route:list`

---

## 📱 Mobile Testing

### iOS Simulator

Update environment:
```json
{
  "base_url": "http://localhost:8000"
}
```

### Android Emulator

Use special localhost:
```json
{
  "base_url": "http://10.0.2.2:8000"
}
```

### Real Device

Use computer's local IP:
```json
{
  "base_url": "http://192.168.1.100:8000"
}
```

Find your IP:
```bash
# macOS/Linux
ifconfig | grep "inet "

# Windows
ipconfig
```

---

## 🔄 Sharing with Team

### Method 1: Share Files

1. Share the 3 JSON files via:
   - Email
   - Slack
   - Cloud storage
   - Git repository

2. Team members import files into their Postman

### Method 2: Team Workspace

1. Create Postman Team Workspace
2. Upload collection to workspace
3. Invite team members
4. Real-time collaboration

### Method 3: Publish Documentation

1. Click collection
2. Click **View documentation**
3. Click **Publish**
4. Share public URL

---

## 🎓 Advanced Usage

### Newman CLI Testing

Run collection from command line:

```bash
# Install Newman
npm install -g newman

# Run collection
newman run Gadazidva_API.postman_collection.json \
  --environment Gadazidva_Environment.postman_environment.json

# Generate HTML report
newman run Gadazidva_API.postman_collection.json \
  --environment Gadazidva_Environment.postman_environment.json \
  --reporters cli,html \
  --reporter-html-export report.html
```

### CI/CD Integration

**GitHub Actions:**
```yaml
name: API Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Install Newman
        run: npm install -g newman
      - name: Run API Tests
        run: |
          newman run Gadazidva_API.postman_collection.json \
            -e Gadazidva_Environment.postman_environment.json
```

### Mock Server

Create mock API for frontend development:

1. Click collection
2. Click **Mocks** tab
3. Click **Create Mock Server**
4. Use mock URL in frontend

---

## 📚 Additional Resources

### Documentation Files

- **`API_DOCUMENTATION.md`** - Complete API reference
- **`LOCALIZATION_GUIDE.md`** - Translation system guide
- **`IMPLEMENTATION_SUMMARY.md`** - Technical implementation details
- **`POSTMAN_COLLECTION_GUIDE.md`** - Detailed Postman guide (this file)
- **`POSTMAN_QUICK_START.md`** - Quick reference

### External Links

- **Postman Learning Center:** https://learning.postman.com/
- **Newman Documentation:** https://learning.postman.com/docs/running-collections/using-newman-cli/command-line-integration-with-newman/
- **Laravel API Documentation:** https://laravel.com/docs/api-resources

---

## ✅ Validation Checklist

Before using the collection, verify:

- [ ] Postman installed (v10 or higher recommended)
- [ ] Laravel application running
- [ ] Database migrated: `php artisan migrate --seed`
- [ ] Collection imported into Postman
- [ ] Environment imported and selected
- [ ] Can access: `http://localhost:8000/api`

---

## 🎉 Collection Features

### What Makes This Collection Great?

✅ **Complete Coverage** - All 60+ API endpoints included

✅ **Production Ready** - Used for actual development and testing

✅ **Well Organized** - Logical folder structure

✅ **Auto Authentication** - Token management handled automatically

✅ **Bilingual** - English and Georgian support

✅ **Documented** - Every request has descriptions

✅ **Example Data** - Ready-to-use test data

✅ **Maintained** - Updated with latest API changes

✅ **Team Friendly** - Easy to share and collaborate

✅ **CI/CD Ready** - Works with Newman CLI

---

## 📞 Support

### Having Issues?

1. **Check Troubleshooting section** above
2. **Review documentation** in included MD files
3. **Verify environment setup**
4. **Check Laravel logs:** `storage/logs/laravel.log`

### Need Help?

- Review `POSTMAN_COLLECTION_GUIDE.md` for detailed instructions
- Check `API_DOCUMENTATION.md` for endpoint specifications
- Consult `LOCALIZATION_GUIDE.md` for translation questions

---

## 🔖 Version Information

- **Collection Version:** 1.0.0
- **API Version:** 1.0
- **Last Updated:** October 28, 2025
- **Format:** Postman Collection v2.1
- **Compatible With:** Postman v10+, Newman v5+

---

## 📝 Notes

- All timestamps use ISO 8601 format
- Dates use `YYYY-MM-DD HH:mm:ss` format
- Currency is GEL (Georgian Lari)
- Rate limiting applies per user
- Soft deletes enabled on most resources

---

## 🎯 Quick Reference

**Import:** Drag JSON files into Postman
**Login:** Authentication → Login → Send
**Token:** Auto-saved after login
**Language:** Change `Accept-Language` header
**Environment:** Select from top-right dropdown

---

**Happy Testing! 🚀**

For detailed instructions, see `POSTMAN_COLLECTION_GUIDE.md`
