# Migration Guide: Laravel → NestJS

## 🎯 Why NestJS?

| Feature | Laravel | NestJS |
|---------|---------|--------|
| **Language** | PHP | TypeScript |
| **Architecture** | MVC/DDD | DDD with Decorators |
| **API** | RESTful | RESTful + GraphQL |
| **Type Safety** | Runtime (PHP 8+) | Compile-time (TypeScript) |
| **Async** | Queues | Native async/await |
| **Performance** | Good | Excellent (Node.js) |
| **Ecosystem** | Composer | npm (largest ecosystem) |

## 📊 Feature Comparison

### ✅ Features We've Replicated

| Feature | Laravel | NestJS | Status |
|---------|---------|--------|--------|
| **Multi-Tenancy** | `TenantScoped` trait | `TenantGuard` | ✅ Done |
| **Authentication** | Sanctum/Passport | Passport JWT | ✅ Done |
| **ORM** | Eloquent | Prisma | ✅ Done |
| **Validation** | Form Requests | class-validator | ✅ Done |
| **JSON → CRUD** | `MakeCrudDomain` | `generate-domain.ts` | ✅ Done |
| **Migrations** | Artisan | Prisma Migrate | ✅ Done |
| **Seeding** | Seeders | seed.ts | ✅ Done |
| **API Docs** | Scramble/L5-Swagger | Swagger | ✅ Done |
| **Middleware** | HTTP Middleware | Guards/Interceptors | ✅ Done |

---

## 🔄 Concept Mapping

### Laravel → NestJS Equivalents

| Laravel | NestJS |
|---------|--------|
| `php artisan app:crud` | `npm run generate:domain` |
| `Route::middleware()` | `@UseGuards()` |
| `Request $request` | `@Body() dto: CreateDto` |
| `Gate::allows()` | `@UseGuards(PolicyGuard)` |
| `Auth::user()` | `@CurrentUser() user` |
| `TenantScoped` | `@CurrentTenant() tenantId` |
| `FormRequest` | `class-validator DTO` |
| `Model::query()` | `prisma.model.findMany()` |
| `HasMany` | Prisma relations |
| `php artisan migrate` | `npm run prisma:migrate` |
| `php artisan serve` | `npm run start:dev` |

---

## 📂 File Structure Comparison

### Laravel (Before)

```
backend/
├── app/
│   ├── Domains/
│   │   ├── Members/
│   │   │   ├── Models/Member.php
│   │   │   ├── Actions/
│   │   │   ├── Repositories/
│   │   │   └── Policies/
│   ├── Http/
│   │   ├── Controllers/MemberController.php
│   │   └── Requests/StoreMemberRequest.php
│   └── Models/User.php
├── database/
│   └── migrations/
└── routes/
    └── api.php
```

### NestJS (After)

```
nestjs/
├── src/
│   ├── domains/
│   │   ├── members/
│   │   │   ├── member/
│   │   │   │   ├── member.controller.ts
│   │   │   │   ├── member.service.ts
│   │   │   │   └── dto/
│   │   │   │       ├── create-member.dto.ts
│   │   │   │       └── update-member.dto.ts
│   │   │   └── member.module.ts
│   └── shared/
│       ├── guards/
│       └── prisma/
└── prisma/
    ├── schema.prisma
    └── migrations/
```

---

## 💾 Database: Eloquent vs Prisma

### Eloquent (Laravel)

```php
// Find all members
$members = Member::where('organisation_id', $tenantId)
    ->where('is_active', true)
    ->with('addresses')
    ->paginate(20);

// Create member
$member = Member::create([
    'first_name' => $request->first_name,
    'organisation_id' => $tenantId,
]);

// Update
$member->update($request->validated());
```

### Prisma (NestJS)

```typescript
// Find all members
const members = await this.prisma.member.findMany({
  where: {
    organisationId: tenantId,
    isActive: true,
  },
  include: {
    addresses: true,
  },
  skip: (page - 1) * 20,
  take: 20,
});

// Create member
const member = await this.prisma.member.create({
  data: {
    firstName: dto.firstName,
    organisationId: tenantId,
  },
});

// Update
await this.prisma.member.update({
  where: { id },
  data: dto,
});
```

---

## 🔐 Authentication: Sanctum vs JWT

### Laravel Sanctum

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'profile']);
});

// Controller
public function profile(Request $request)
{
    return $request->user();
}
```

### NestJS JWT

```typescript
// Controller
@UseGuards(JwtAuthGuard)
@Get('profile')
getProfile(@CurrentUser() user: any) {
  return user;
}
```

---

## ✅ Validation: Form Requests vs DTOs

### Laravel Form Request

```php
class StoreMemberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:members'],
            'date_of_birth' => ['nullable', 'date'],
        ];
    }
}
```

### NestJS DTO

```typescript
export class CreateMemberDto {
  @IsString()
  @MaxLength(50)
  firstName: string;

  @IsEmail()
  email: string;

  @IsOptional()
  @IsDate()
  @Type(() => Date)
  dateOfBirth?: Date;
}
```

---

## 🏢 Multi-Tenancy

### Laravel

```php
// Trait
trait TenantScoped
{
    protected static function bootTenantScoped()
    {
        static::addGlobalScope('tenant', function ($query) {
            $query->where('organisation_id', Auth::user()->organisation_id);
        });
    }
}

// Usage
class Member extends Model
{
    use TenantScoped;
}
```

### NestJS

```typescript
// Guard
@Injectable()
export class TenantGuard implements CanActivate {
  canActivate(context: ExecutionContext): boolean {
    const request = context.switchToHttp().getRequest();
    request.tenantId = request.user.organisationId;
    return true;
  }
}

// Usage
@UseGuards(JwtAuthGuard, TenantGuard)
@Get()
findAll(@CurrentTenant() tenantId: number) {
  return this.service.findAll(tenantId);
}
```

---

## 🔧 CRUD Generation

### Laravel

```bash
php artisan app:crud Members Member --force
```

Generates:
- Model
- Migration
- Controller
- Form Requests
- Policy

### NestJS

```bash
npm run generate:domain -- --domain=Members --entity=Member
```

Generates:
- Prisma model (from JSON)
- Module
- Controller
- Service
- DTOs

---

## 🚀 What's Better in NestJS?

### 1. Type Safety

```typescript
// TypeScript catches errors at compile-time
const member: Member = await this.prisma.member.findUnique({
  where: { id: 'invalid' }, // ❌ Error: Type 'string' not assignable to 'number'
});
```

### 2. Auto-Completion

TypeScript provides full IntelliSense for:
- Database queries
- API parameters
- DTO fields
- Relations

### 3. Async/Await Native

```typescript
// No need for queues for simple async tasks
async function processOrder(orderId: number) {
  const order = await this.orderService.find(orderId);
  await this.paymentService.charge(order);
  await this.emailService.sendConfirmation(order);
}
```

### 4. Testing

```typescript
// Built-in testing utilities
describe('MemberService', () => {
  it('should create member', async () => {
    const result = await service.create(dto, tenantId);
    expect(result).toHaveProperty('id');
  });
});
```

---

## 📦 Package Equivalents

| Laravel Package | NestJS Package |
|----------------|---------------|
| `laravel/sanctum` | `@nestjs/jwt` + `passport-jwt` |
| `spatie/laravel-permission` | Custom guards |
| `barryvdh/laravel-cors` | Built-in CORS |
| `fruitcake/laravel-cors` | Built-in |
| `laravel/telescope` | Built-in logging |
| `laravel/horizon` | Bull queue |

---

## 🎯 Migration Checklist

- [x] Project structure
- [x] Prisma schema generator
- [x] NestJS CRUD generator
- [x] JWT authentication
- [x] Multi-tenancy guards
- [x] Validation with DTOs
- [x] Pagination helper
- [x] Swagger documentation
- [ ] Generate all 9 domains
- [ ] Policy guards (roles/permissions)
- [ ] File upload handling
- [ ] Email service
- [ ] Queue system
- [ ] Logging/monitoring
- [ ] Rate limiting
- [ ] CORS configuration
- [ ] Production deployment

---

## 🎓 Learning Resources

### NestJS

- [Official Docs](https://docs.nestjs.com/)
- [NestJS Course](https://courses.nestjs.com/)

### Prisma

- [Prisma Docs](https://www.prisma.io/docs)
- [Prisma Schema Reference](https://www.prisma.io/docs/reference/api-reference/prisma-schema-reference)

### TypeScript

- [TypeScript Handbook](https://www.typescriptlang.org/docs/handbook/intro.html)

---

## 💡 Pro Tips

1. **Keep domain JSONs as single source of truth** - Both Laravel and NestJS can coexist using the same specs
2. **Run generators often** - They're fast and idempotent
3. **Use Prisma Studio** - Great visual database browser
4. **Leverage TypeScript** - Let the compiler catch bugs
5. **Test with Swagger** - Interactive API testing built-in

---

## 🆘 Common Issues

### Issue: Prisma Client Not Generated

```bash
npm run prisma:generate
```

### Issue: Migration Conflicts

```bash
npx prisma migrate reset
npm run prisma:migrate
npm run prisma:seed
```

### Issue: TypeScript Errors

```bash
# Clear build cache
rm -rf dist/
npm run build
```

---

**Ready to migrate?** Follow the [GETTING-STARTED.md](./GETTING-STARTED.md) guide!
