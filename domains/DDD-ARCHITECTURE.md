# Club Member Management - DDD Backend

Laravel backend using Domain-Driven Design (DDD) architecture with automatic CRUD generation from JSON specifications.

## Project Structure

```
app/
├── Console/Commands/
│   └── MakeCrudDomain.php          # CRUD generator command
├── Domains/                        # Domain-driven architecture
│   ├── Members/                    # Member domain
│   │   ├── Models/
│   │   ├── Actions/
│   │   ├── Repositories/
│   │   ├── Policies/
│   │   └── Events/
│   ├── Tenancy/                    # Multi-tenancy domain
│   ├── Products/
│   ├── Orders/
│   ├── Subscriptions/
│   ├── Financial/
│   ├── Content/
│   ├── Forms/
│   └── Shared/
├── Http/
│   ├── Controllers/                # Generated controllers
│   └── Requests/                   # Form validation requests
├── Models/
│   └── User.php
└── Shared/
    └── Tenancy/
        └── TenantScoped.php        # Multi-tenant scoping trait

domains/                            # JSON domain specifications
├── members.json
├── tenancy.json
├── products.json
├── orders.json
├── subscriptions.json
├── financial.json
├── content.json
├── forms.json
├── shared.json
└── dump-membi-202601261220.sql    # Source database dump
```

## Domain JSON Specification

Each domain is defined in a JSON file in the `domains/` folder. These JSON files are the **single source of truth** for the application structure.

### JSON Structure

```json
{
  "domain": "DomainName",
  "namespace": "App\\Domains\\DomainName",
  "tenant": {                       // Optional: multi-tenancy config
    "mode": "single_db_scoped",
    "tenant_table": "organisations",
    "tenant_key": "organisation_id"
  },
  "entities": {
    "EntityName": {
      "table": "table_name",
      "aggregate_root": true,       // Generate full CRUD
      "polymorphic": false,         // Is polymorphic relation
      "timestamps": true,
      "fillable": ["field1", "field2"],
      "policies": ["view", "update", "delete"],
      
      "fields": {
        "id": { "type": "bigIncrements" },
        "name": { 
          "type": "string", 
          "length": 255,
          "nullable": true,
          "unique": false,
          "index": false,
          "default": "value"
        }
      },
      
      "indexes": [
        { "columns": ["col1", "col2"], "type": "index" }
      ],
      
      "relations": {
        "belongsTo": {
          "relationName": {
            "entity": "RelatedEntity",
            "domain": "RelatedDomain",
            "fk": "foreign_key",
            "ref": "id"
          }
        },
        "hasMany": { /* ... */ },
        "hasOne": { /* ... */ },
        "morphTo": {
          "relationName": {}
        },
        "morphMany": {
          "relationName": {
            "entity": "RelatedEntity",
            "domain": "RelatedDomain",
            "morph": "morphable"
          }
        }
      },
      
      "requests": {
        "store": {
          "class": "StoreEntityRequest",
          "rules": {
            "field": ["required", "string", "max:255"]
          }
        },
        "update": {
          "class": "UpdateEntityRequest",
          "rules": { /* ... */ }
        }
      },
      
      "events": [
        { "name": "EntityCreated", "payload": ["id"] }
      ]
    }
  }
}
```

### Supported Field Types

| Type | Description | Options |
|------|-------------|---------|
| `bigIncrements` | Auto-increment primary key | - |
| `string` | VARCHAR | `length`, `nullable`, `default`, `unique`, `index` |
| `char` | CHAR | `length`, `nullable`, `default` |
| `text` | TEXT | `nullable` |
| `unsignedBigInteger` | BIGINT UNSIGNED | `nullable`, `index`, `default` |
| `unsignedInteger` | INT UNSIGNED | `nullable`, `default` |
| `unsignedTinyInteger` | TINYINT UNSIGNED | `nullable`, `default` |
| `integer` | INT | `nullable`, `default` |
| `decimal` | DECIMAL | `precision`, `scale`, `nullable`, `default` |
| `boolean` | TINYINT(1) | `default` |
| `date` | DATE | `nullable` |
| `datetime` | DATETIME | `nullable` |
| `timestamp` | TIMESTAMP | `nullable` |
| `json` | JSON | `nullable` |
| `enum` | ENUM | `values[]`, `default` |

### Polymorphic Relations

For entities that can belong to multiple parent types:

```json
{
  "Address": {
    "polymorphic": true,
    "fields": {
      "addressable_type": { "type": "string" },
      "addressable_id": { "type": "unsignedBigInteger" }
    },
    "indexes": [
      { "columns": ["addressable_type", "addressable_id"], "type": "index" }
    ],
    "relations": {
      "morphTo": {
        "addressable": {}
      }
    }
  }
}
```

Parent entities use `morphMany`:

```json
{
  "Member": {
    "relations": {
      "morphMany": {
        "addresses": {
          "entity": "Address",
          "domain": "Members",
          "morph": "addressable"
        }
      }
    }
  }
}
```

## CRUD Generation Command

### Usage

```bash
# Generate CRUD for a specific entity
php artisan app:crud {domain} {entity}

# Force regenerate (overwrite existing files)
php artisan app:crud {domain} {entity} --force
```

### Examples

```bash
# Generate Member CRUD
php artisan app:crud Members Member

# Generate Organisation CRUD (with overwrite)
php artisan app:crud Tenancy Organisation --force

# Generate all entities in a domain
php artisan app:crud Members Member
php artisan app:crud Members Address
php artisan app:crud Members Contact
```

### What Gets Generated

For **Aggregate Roots** (entities with `"aggregate_root": true`):

1. **Model** (`app/Domains/{Domain}/Models/{Entity}.php`)
   - Table name
   - Fillable attributes
   - Relations (belongsTo, hasMany, hasOne, morphTo, morphMany)
   - TenantScoped trait (if has organisation_id)

2. **Migration** (`database/migrations/create_{table}_table.php`)
   - All field definitions
   - Indexes
   - Timestamps (if enabled)

3. **Repository** (`app/Domains/{Domain}/Repositories/{Entity}Repository.php`)
   - create(), update(), find(), paginate()

4. **Actions** (`app/Domains/{Domain}/Actions/`)
   - Create{Entity}.php
   - Update{Entity}.php

5. **Controller** (`app/Http/Controllers/{Domain}/{Entity}Controller.php`)
   - index(), store(), update()
   - Dependency injection for Repository and Actions

6. **Requests** (`app/Http/Requests/`)
   - Store{Entity}Request.php
   - Update{Entity}Request.php
   - Validation rules from JSON

7. **Routes** (`routes/{Domain}.php`)
   - API resource routes (no duplicates)

8. **Policies** (`app/Domains/{Domain}/Policies/{Entity}Policy.php`)
   - Authorization methods from JSON

9. **Events** (`app/Domains/{Domain}/Events/`)
   - Event classes from JSON

For **Non-Aggregate entities**:
- Only Model and Migration are generated

## Multi-Tenancy

The system supports single-database multi-tenancy with automatic scoping.

### Configuration

In domain JSON:
```json
{
  "tenant": {
    "mode": "single_db_scoped",
    "tenant_table": "organisations",
    "tenant_key": "organisation_id"
  }
}
```

### TenantScoped Trait

Automatically applied to models with `organisation_id` field:

```php
trait TenantScoped
{
    protected static function bootTenantScoped()
    {
        // Auto-scope all queries by active organisation
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Auth::check() && Schema::hasColumn($builder->getModel()->getTable(), 'organisation_id')) {
                $builder->where($builder->getModel()->getTable().'.organisation_id', Auth::user()->active_organisation_id);
            }
        });

        // Auto-fill organisation_id on create
        static::creating(function ($model) {
            if (Auth::check() && Schema::hasColumn($model->getTable(), 'organisation_id')) {
                $model->organisation_id = Auth::user()->active_organisation_id;
            }
        });
    }
}
```

## Existing Domains

### Members Domain
- **Member**: Core member entity with polymorphic addresses and contacts
- **Address**: Polymorphic addresses (can belong to Member, Organisation, etc.)
- **Contact**: Polymorphic contacts (emergency contacts, etc.)

### Tenancy Domain
- **Organisation**: Tenant entity
- **OrganisationConfig**: Key-value configuration
- **OrganisationRole**: Roles within organisation
- **OrganisationList**: Custom lists
- **OrganisationConfigAdmin**: Admin assignments
- **OrganisationConfigFinancial**: Financial settings
- **OrganisationConfigMember**: Member settings
- **OrganisationConfigSubscription**: Subscription settings

### Products Domain
- **Product**: Products with options and images
- **ProductCategory**: Product categorization
- **ProductOption**: Product options (size, color, etc.)
- **ProductOptionVariant**: Option variants with pricing
- **ProductImage**: Product images
- **ProductEventRule**: Event-based rules
- **ProductRecurringRule**: Recurring product rules

### Orders Domain
- **Order**: Customer orders
- **OrderItem**: Line items in orders

### Subscriptions Domain
- **Subscription**: Membership subscriptions
- **SubscriptionAutoRenewal**: Auto-renewal configuration
- **SubscriptionPriceOption**: Pricing options
- **SubscriptionPriceRenewal**: Renewal pricing
- **SubscriptionPriceLateFee**: Late fee structure

### Financial Domain
- **Invoice**: Member invoices
- **InvoiceLine**: Invoice line items
- **Payment**: Payment records
- **PaymentMethod**: Payment method configuration
- **TaxRate**: Tax rates per organisation
- **Vat**: VAT rates per country
- **AccountingCode**: Chart of accounts codes

### Content Domain
- **Article**: CMS articles
- **ArticleCategory**: Nested article categories
- **ArticleTag**: Article tags
- **Faq**: FAQ entries
- **FaqCategory**: FAQ categories
- **FaqTag**: FAQ tags
- **Document**: Polymorphic document attachments
- **Email**: Email log
- **EmailTemplate**: Email templates

### Forms Domain
- **VirtualForm**: Dynamic forms
- **VirtualField**: Form fields with validation
- **VirtualRecord**: Form submissions (polymorphic)

### Shared Domain
- **Country**: Countries with currency info
- **Zone**: States/provinces
- **Lookup**: System lookups/enums

## Development Workflow

### 1. Update/Create JSON
Edit or create JSON file in `domains/` folder based on SQL structure or requirements.

### 2. Generate CRUD
```bash
php artisan app:crud DomainName EntityName --force
```

### 3. Run Migrations
```bash
php artisan migrate:fresh
```

### 4. Test API Endpoints
```bash
# List all members
GET /api/members

# Create member
POST /api/members

# Update member
PUT /api/members/{id}

# Delete member
DELETE /api/members/{id}
```

## API Routes

Routes are automatically registered in `routes/{Domain}.php` files.

Include in `routes/api.php`:
```php
require __DIR__.'/Members.php';
require __DIR__.'/Tenancy.php';
require __DIR__.'/Products.php';
// ... etc
```

## Best Practices

1. **JSON as Source of Truth**: Always update JSON first, then regenerate
2. **Use --force**: When updating existing entities, use --force flag
3. **Aggregate Roots**: Only mark entities as aggregate_root if they need full CRUD
4. **Polymorphic Relations**: Use for entities that can belong to multiple parents
5. **Fillable**: Always specify fillable fields for mass assignment
6. **Validation**: Define request validation rules in JSON
7. **Policies**: Add policies array for authorization

## Troubleshooting

### Duplicate Routes
The command now prevents duplicate route generation. If you have duplicates, manually clean the route file.

### Migration Conflicts
Use `migrate:fresh` during development or manually delete old migration files.

### Missing Relations
Ensure both sides of the relation are properly defined in their respective JSONs.

### Tenant Scoping Not Working
Check that:
- Entity has `organisation_id` field
- User model has `active_organisation_id` field
- User is authenticated

## Next Steps

1. Extract remaining tables from SQL dump to JSON
2. Generate CRUD for all domains
3. Implement authentication and authorization
4. Add API documentation (Swagger/OpenAPI)
5. Write integration tests
