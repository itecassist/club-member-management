# Getting Started with Membi NestJS Backend

## 🎯 Quick Setup

### 1. Install Dependencies

```bash
cd nestjs
npm install
```

### 2. Configure Environment

```bash
# Copy environment template
cp .env.example .env

# Edit .env with your PostgreSQL credentials
# DATABASE_URL="postgresql://username:password@localhost:5432/membi?schema=public"
# JWT_SECRET=your-secret-key-here
```

### 3. Set Up Database

```bash
# Generate Prisma client
npm run prisma:generate

# Create database migrations
npm run prisma:migrate

# Seed database with test data
npm run prisma:seed
```

### 4. Start Development Server

```bash
npm run start:dev
```

🚀 The API will be available at: `http://localhost:3000`

📚 Swagger docs: `http://localhost:3000/api/docs`

---

## 🔐 Test Credentials

After seeding, you can login with:

- **Email**: `admin@testorg.com`
- **Password**: `password123`

---

## 📦 Generating Domain Modules

The project uses your existing domain JSON files to auto-generate all CRUD operations!

### Generate Prisma Schema from Domain JSONs

```bash
npm run generate:prisma
```

This reads all JSON files from `../domains/` and generates the Prisma schema.

### Generate NestJS CRUD Modules

```bash
# Generate all domains
npm run generate:domain

# Generate specific domain
npm run generate:domain -- --domain=Members

# Generate specific entity
npm run generate:domain -- --domain=Members --entity=Member
```

This generates for each entity:
- ✅ Module (with dependency injection)
- ✅ Controller (with all CRUD endpoints)
- ✅ Service (with business logic)
- ✅ DTOs (with validation)
- ✅ Auto-wired with JWT auth & multi-tenancy

---

## 🏗️ Project Structure

```
nestjs/
├── src/
│   ├── domains/              # Domain modules (generated)
│   │   ├── auth/            # Authentication
│   │   ├── tenancy/         # Organizations
│   │   ├── members/         # Member management
│   │   └── ...              # Other domains
│   ├── shared/
│   │   ├── decorators/      # @CurrentUser, @CurrentTenant
│   │   ├── guards/          # JwtAuthGuard, TenantGuard
│   │   ├── interceptors/    # Response transformation
│   │   ├── dto/             # Shared DTOs (pagination)
│   │   └── prisma/          # Prisma service
│   ├── app.module.ts
│   └── main.ts
├── prisma/
│   ├── schema.prisma        # Database schema
│   └── seed.ts              # Database seeding
├── scripts/
│   ├── generate-prisma.ts   # JSON → Prisma converter
│   └── generate-domain.ts   # JSON → NestJS CRUD generator
└── domains/                 # Symlink to ../domains (JSON specs)
```

---

## 🔄 Development Workflow

### 1. Define Your Domain (Already Done!)

Your domain JSON files in `../domains/` are already perfect:
- `members.json`
- `tenancy.json`
- `subscriptions.json`
- `orders.json`
- `financial.json`
- `products.json`
- `content.json`
- `forms.json`
- `shared.json`

### 2. Generate Everything

```bash
# Step 1: Generate Prisma schema from JSONs
npm run generate:prisma

# Step 2: Generate Prisma client
npm run prisma:generate

# Step 3: Create migration
npm run prisma:migrate

# Step 4: Generate NestJS modules
npm run generate:domain
```

### 3. Use the API

All endpoints are automatically:
- ✅ Protected with JWT authentication
- ✅ Scoped to organization (multi-tenant)
- ✅ Validated with DTOs
- ✅ Documented in Swagger

---

## 📡 API Example

### Login

```bash
curl -X POST http://localhost:3000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@testorg.com",
    "password": "password123"
  }'
```

Response:
```json
{
  "statusCode": 200,
  "data": {
    "user": {
      "id": 1,
      "email": "admin@testorg.com",
      "firstName": "Admin",
      "lastName": "User",
      "organisationId": 1
    },
    "token": {
      "accessToken": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
      "expiresIn": "1d"
    }
  }
}
```

### Get All Members (Authenticated)

```bash
curl -X GET http://localhost:3000/api/v1/members \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

Response:
```json
{
  "statusCode": 200,
  "data": [...],
  "meta": {
    "page": 1,
    "limit": 20,
    "total": 50,
    "totalPages": 3,
    "hasNextPage": true,
    "hasPreviousPage": false
  }
}
```

---

## 🎨 Key Features

### 1. Multi-Tenancy (Automatic)

Every request is automatically scoped to the user's organization:

```typescript
@Get()
findAll(@CurrentTenant() tenantId: number) {
  // tenantId is automatically extracted from JWT
  return this.service.findAll(tenantId);
}
```

### 2. JWT Authentication

Protected routes use guards:

```typescript
@UseGuards(JwtAuthGuard, TenantGuard)
@Get('protected')
protectedRoute(@CurrentUser() user: any) {
  // user is automatically injected from JWT
  return user;
}
```

### 3. Pagination

All list endpoints support pagination:

```bash
GET /api/v1/members?page=2&limit=50&sortBy=createdAt&sortOrder=desc&search=john
```

### 4. Validation

DTOs are auto-validated using class-validator:

```typescript
export class CreateMemberDto {
  @IsEmail()
  email: string;

  @IsString()
  @MinLength(2)
  firstName: string;
  
  // Validation happens automatically!
}
```

---

## 🔧 Customization

### Adding Custom Endpoints

Edit the generated controller:

```typescript
// src/domains/members/member/member.controller.ts

@Get('active')
@ApiOperation({ summary: 'Get active members only' })
getActiveMembers(@CurrentTenant() tenantId: number) {
  return this.memberService.findActive(tenantId);
}
```

### Adding Business Logic

Edit the generated service:

```typescript
// src/domains/members/member/member.service.ts

async findActive(tenantId: number) {
  return this.prisma.member.findMany({
    where: {
      organisationId: tenantId,
      isActive: true,
    },
  });
}
```

### Custom Validation

Edit the DTO:

```typescript
// src/domains/members/member/dto/create-member.dto.ts

@IsEmail()
@Transform(({ value }) => value.toLowerCase())
email: string;
```

---

## 🚀 Production Deployment

### 1. Build

```bash
npm run build
```

### 2. Run Migrations

```bash
npx prisma migrate deploy
```

### 3. Start

```bash
npm run start:prod
```

---

## 📊 Database Management

### View Database in Prisma Studio

```bash
npm run prisma:studio
```

Opens a GUI at `http://localhost:5555`

### Create Migration

```bash
npm run prisma:migrate
```

### Reset Database

```bash
npx prisma migrate reset
```

⚠️ This will delete all data!

---

## 🧪 Testing

```bash
# Unit tests
npm run test

# E2E tests
npm run test:e2e

# Coverage
npm run test:cov
```

---

## 📈 Next Steps

1. ✅ Run `npm install`
2. ✅ Configure `.env`
3. ✅ Run migrations
4. ✅ Seed database
5. ✅ Start dev server
6. ✅ Test login in Swagger
7. ✅ Generate all domain modules
8. 🎉 Start building custom features!

---

## 🆘 Troubleshooting

### Database Connection Error

```bash
# Check PostgreSQL is running
psql -U postgres -d membi

# Update DATABASE_URL in .env
```

### Prisma Client Not Found

```bash
npm run prisma:generate
```

### Module Not Found

```bash
# Clear node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

---

## 📝 Notes

- All domain JSONs remain in `../domains/` (shared with Laravel)
- Generated code is in `nestjs/src/domains/`
- Migrations are in `nestjs/prisma/migrations/`
- The generators are idempotent - safe to run multiple times
- Custom modifications won't be overwritten if you edit generated files

---

**Need help?** Check the Swagger docs at `/api/docs` or review the Laravel backend for reference implementations.
