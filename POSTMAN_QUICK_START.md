# Postman Quick Start

## 🚀 3-Step Setup

### 1️⃣ Import Collection
```
Open Postman → Import → Select "Gadazidva_API.postman_collection.json"
```

### 2️⃣ Import Environment
```
Import → Select "Gadazidva_Environment.postman_environment.json"
Select environment from dropdown (top right)
```

### 3️⃣ Login
```
Authentication → Login → Send
✅ Token automatically saved!
```

---

## 📁 Files Included

| File | Purpose |
|------|---------|
| `Gadazidva_API.postman_collection.json` | Complete API collection (50 requests) |
| `Gadazidva_Environment.postman_environment.json` | Local environment |
| `Gadazidva_Production_Environment.postman_environment.json` | Production environment |

---

## 🎯 Quick Test

```
1. Login → Get token ✅
2. Service Posts → List Service Posts → Send ✅
3. Driver Profiles → List Driver Profiles → Send ✅
```

---

## 🌐 Switch Language

Change `Accept-Language` header:
- **English:** `en`
- **Georgian:** `ka`

---

## 📂 Collection Structure

```
9 Folders
├── Authentication (4)
├── Service Posts (6)
├── Driver Profiles (8)
├── Helper Posts (8)
├── Assistant Profiles (8)
├── Ratings (4)
├── Distance Calculator (2)
├── Messaging (6)
└── Payments (4)

Total: 50 Requests
```

---

## 🔑 Environment Variables

```
base_url = http://localhost:8000
auth_token = (auto-filled after login)
language = en
```

---

## ⚡ Common Actions

### Get Service Posts
```
GET {{base_url}}/api/service-posts
```

### Create Service Post (requires auth)
```
POST {{base_url}}/api/service-posts
Authorization: Bearer {{auth_token}}
```

### Rate a Driver
```
POST {{base_url}}/api/ratings
{
  "rated_id": 5,
  "rateable_type": "App\\Models\\DriverProfile",
  "rateable_id": 3,
  "rating": 4.5,
  "comment": "Great driver!"
}
```

---

## 🔧 Troubleshooting

**Unauthorized Error?**
→ Make sure you logged in first

**Variables not working?**
→ Check environment is selected (top right)

**404 Error?**
→ Verify Laravel server is running: `php artisan serve`

---

## 📚 Full Guide

See `POSTMAN_COLLECTION_GUIDE.md` for:
- Detailed workflows
- Testing scenarios
- Advanced features
- CI/CD integration
- Complete examples

---

## ✅ Ready to Go!

Your collection includes:
- ✅ 50 API endpoints
- ✅ Automatic authentication
- ✅ Bilingual support (EN/KA)
- ✅ Example data
- ✅ Full documentation

**Start Testing Now!** 🎉
