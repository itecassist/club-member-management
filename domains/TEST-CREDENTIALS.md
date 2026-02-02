# Test Credentials & API Testing Guide

## 🔐 Login Credentials

All passwords are: `password`

### Super Admin (Access to ALL organizations)
- **Email:** `admin@membi.com`
- **Password:** `password`
- **Access:** All 3 organizations with super_admin role

### Organization Admins (1 per org)
1. **Acme Sports Club**
   - Email: `admin@acme-sports.com`
   - Role: admin

2. **Green Valley Association**
   - Email: `admin@green-valley.com`
   - Role: admin

3. **Tech Professionals Network**
   - Email: `admin@tech-pros.com`
   - Role: admin

### Regular Users (1 per org)
1. **Acme Sports Club**
   - Email: `user@acme-sports.com`
   - Role: member

2. **Green Valley Association**
   - Email: `user@green-valley.com`
   - Role: member

3. **Tech Professionals Network**
   - Email: `user@tech-pros.com`
   - Role: member

---

## 📊 Test Data Created

- **3 Organizations** - Acme Sports Club, Green Valley Association, Tech Professionals Network
- **7 Users** - 1 super admin + 6 org users (2 per org)
- **15 Members** - 5 per organization

---

## 🧪 API Testing Examples

### 1. Login as Super Admin
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@membi.com","password":"password"}'
```

**Response:**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "Super Admin",
    "email": "admin@membi.com",
    "active_organisation_id": 1
  },
  "access_token": "YOUR_TOKEN_HERE",
  "token_type": "Bearer"
}
```

### 2. Get Current User Profile
```bash
curl http://localhost:8000/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 3. Get All Organisations (Super Admin)
```bash
curl http://localhost:8000/api/organisations \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 4. Get All Members (Returns members from active organisation)
```bash
curl http://localhost:8000/api/members \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 5. Create a New Member
```bash
curl -X POST http://localhost:8000/api/members \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "organisation_id": 1,
    "first_name": "John",
    "last_name": "Smith",
    "email": "john.smith@test.com",
    "mobile_phone": "+44 7123 456789",
    "date_of_birth": "1990-01-15",
    "gender": "male",
    "joined_at": "2026-02-01",
    "is_active": true,
    "roles": ["member"],
    "last_login_at": "2026-02-01 12:00:00"
  }'
```

### 6. Register New User
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### 7. Logout
```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 🎯 Quick Test Workflow

1. **Login as super admin** to get access token
2. **Test GET /api/me** to see user profile with all organisations
3. **Test GET /api/organisations** to see all 3 organizations
4. **Test GET /api/members** to see members from active organisation
5. **Create a new member** using POST /api/members
6. **Switch between organizations** (if you implement org switching endpoint)

---

## 📋 Database Summary

### Users Table
- 1 super admin with access to all orgs
- 6 regular users (2 per org)

### Organisations Table
- Acme Sports Club (id: 1)
- Green Valley Association (id: 2)
- Tech Professionals Network (id: 3)

### Members Table
- 15 members total (5 per org)
- Each member has:
  - Unique member number (MEM000001, etc.)
  - Valid email, phone, DOB
  - Gender, title, active status
  - JSON roles field
  - Last login timestamp

---

## 🔍 Testing Multi-Tenancy

The super admin (`admin@membi.com`) has access to ALL organizations, so you can test:

1. Login as super admin
2. Query members from different organisations
3. Switch active organisation
4. Verify data isolation between orgs

---

## 💡 Tips

- All endpoints under `/api/` except `/register` and `/login` require authentication
- Use `Authorization: Bearer {token}` header for authenticated requests
- Token is returned on successful login/registration
- Super admin can access all organisations
- Regular users can only access their assigned organisation(s)

---

## 🚀 Next Steps

1. Test all endpoints with Postman/Insomnia
2. Implement organisation switching for super admin
3. Add role-based permissions
4. Test CRUD operations on other domains (Products, Orders, etc.)
5. Implement 2FA if needed

---

**All set for API testing!** 🎉
