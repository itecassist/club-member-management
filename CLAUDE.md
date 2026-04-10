# Membi - Club Member Management System

**Status**: Beta Complete | **Entities**: 54 across 11 domains | **Coverage**: 100%

Full reference: `domains/Claude.md` | Architecture deep-dive: `domains/DDD-ARCHITECTURE.md`

---

## Tech Stack

- **Backend**: Laravel 12, PHP 8.2+, MySQL/MariaDB — located in `backend/`
- **Frontend**: Next.js — located in `frontend/`
- **Architecture**: Domain-Driven Design (DDD), single-database multi-tenancy
- **API**: RESTful JSON

---

## Project Structure

```
backend/                         # Laravel 12 application
  app/
    Console/Commands/
      MakeCrudDomain.php         # CRUD generator — the heart of the system
    Domains/{Domain}/            # Domain-isolated code
      Models/, Actions/, Repositories/, Policies/, Events/
    Http/Controllers/{Domain}/
    Shared/Tenancy/TenantScoped.php  # Auto-scopes queries by organisation_id
  database/migrations/
  routes/{Domain}.php            # Generated per domain

frontend/                        # Next.js application

domains/                         # JSON domain specs — SOURCE OF TRUTH
  *.json                         # 11 files, one per domain
  Claude.md                      # Full project reference (1,483 lines)
  QUICK-START.md
  DDD-ARCHITECTURE.md
  GENERATE-ALL.md
  TEST-CREDENTIALS.md
```

---

## The Golden Rule

**JSON files in `domains/` are the single source of truth.**  
Always update the JSON first, then regenerate. Never manually edit generated files.

---

## CRUD Generator

```bash
# Generate (or regenerate) an entity
php artisan app:crud {Domain} {Entity} --force

# Examples
php artisan app:crud Members Member --force
php artisan app:crud Financial Invoice --force
```

**Aggregate Root** (`"aggregate_root": true`) → generates Model, Migration, Controller, Repository, Actions, Requests, Routes, Policy, Events

**Supporting Entity** (`"aggregate_root": false`) → generates only Model and Migration

---

## All 11 Domains

| Domain | Entities | Aggregate Roots | Purpose |
|--------|----------|-----------------|---------|
| Members | 3 | 1 | Member profiles, polymorphic addresses/contacts |
| Tenancy | 8 | 2 | Multi-tenant organisations and config |
| Shared | 3 | 3 | Countries, zones, system lookups |
| Products | 7 | 3 | Product catalog with variants and options |
| Orders | 2 | 1 | Order processing |
| Subscriptions | 5 | 1 | Membership subscriptions and pricing |
| Financial | 9 | 4 | Invoices, payments, balances, transactions |
| Content | 9 | 6 | Articles, FAQs, documents, email templates |
| Forms | 3 | 1 | Dynamic virtual forms |
| Groups | 2 | 1 | Family/corporate/club groups |
| Auth | 5 | 2 | Roles, permissions, 2FA |

---

## Generate All 54 Entities (PowerShell)

```powershell
@('Members Member','Members Address','Members Contact','Tenancy Organisation','Tenancy OrganisationConfig','Tenancy OrganisationRole','Tenancy OrganisationList','Tenancy OrganisationConfigAdmin','Tenancy OrganisationConfigFinancial','Tenancy OrganisationConfigMember','Tenancy OrganisationConfigSubscription','Shared Country','Shared Zone','Shared Lookup','Products Product','Products ProductCategory','Products ProductOption','Products ProductOptionVariant','Products ProductImage','Products ProductEventRule','Products ProductRecurringRule','Orders Order','Orders OrderItem','Subscriptions Subscription','Subscriptions SubscriptionAutoRenewal','Subscriptions SubscriptionPriceOption','Subscriptions SubscriptionPriceRenewal','Subscriptions SubscriptionPriceLateFee','Financial Invoice','Financial InvoiceLine','Financial Payment','Financial PaymentMethod','Financial TaxRate','Financial Vat','Financial AccountingCode','Financial AccountBalance','Financial AccountTransaction','Content Article','Content ArticleCategory','Content ArticleTag','Content Faq','Content FaqCategory','Content FaqTag','Content Document','Content Email','Content EmailTemplate','Forms VirtualForm','Forms VirtualField','Forms VirtualRecord','Groups Group','Groups GroupMember','Auth Permission','Auth Role','Auth RolePermission','Auth UserRole','Auth TwoFactorAuthentication') | ForEach-Object { $parts = $_ -split ' '; php artisan app:crud $parts[0] $parts[1] --force }
```

---

## Common Commands

```bash
php artisan migrate:fresh          # Fresh migration (dev)
php artisan migrate                # Run new migrations (production)
php artisan serve                  # Start dev server
php artisan cache:clear            # Clear all caches
php artisan route:clear
php artisan test                   # Run tests
```

---

## Multi-Tenancy

Single-database multi-tenancy via `organisation_id`. Any model with `organisation_id` automatically gets the `TenantScoped` trait applied by the generator — all queries are scoped to the authenticated user's `active_organisation_id`.

To bypass scoping (admins only): `Model::withoutGlobalScope('tenant')->get()`

---

## API

- Pattern: `GET/POST/PUT/DELETE /api/{entities}/{id?}`
- Include all domain routes in `routes/api.php` via `require __DIR__.'/{Domain}.php'`
- All passwords in test data: `password`
- Super admin: `admin@membi.com` | Org admins: `admin@acme-sports.com`, `admin@green-valley.com`, `admin@tech-pros.com`
- See `domains/TEST-CREDENTIALS.md` for full test data

---

## Development Workflow

1. Edit the entity definition in `domains/{domain}.json`
2. Run `php artisan app:crud {Domain} {Entity} --force`
3. Run `php artisan migrate` (or `migrate:fresh` in dev)
4. Test via API

## Key JSON Structure

```json
{
  "domain": "DomainName",
  "entities": {
    "EntityName": {
      "aggregate_root": true,
      "table": "table_name",
      "polymorphic": false,
      "timestamps": true,
      "fields": { "id": { "type": "bigIncrements" }, "name": { "type": "string", "nullable": true } },
      "indexes": [{ "columns": ["col1", "col2"] }],
      "relations": { "belongsTo": {}, "hasMany": {}, "morphMany": {} },
      "fillable": ["name"],
      "validation": { "name": "required|string|max:255" }
    }
  }
}
```

Supported field types: `bigIncrements`, `string`, `char`, `text`, `unsignedBigInteger`, `unsignedInteger`, `unsignedTinyInteger`, `integer`, `decimal`, `boolean`, `date`, `datetime`, `timestamp`, `json`, `enum`

Supported relations: `belongsTo`, `hasMany`, `hasOne`, `morphTo`, `morphMany`, `belongsToMany`
