# Quick Start Guide

## Step-by-Step: Regenerate All Domains

### 1. Clean Existing Generated Files (Optional)
```bash
# Remove old migrations
Remove-Item database/migrations/create_*.php

# Or just run fresh migrations later
```

### 2. Generate All CRUD (Copy & Paste)

```bash
# Members Domain
php artisan app:crud Members Member --force
php artisan app:crud Members Address --force
php artisan app:crud Members Contact --force

# Tenancy Domain
php artisan app:crud Tenancy Organisation --force
php artisan app:crud Tenancy OrganisationConfig --force
php artisan app:crud Tenancy OrganisationRole --force
php artisan app:crud Tenancy OrganisationList --force
php artisan app:crud Tenancy OrganisationConfigAdmin --force
php artisan app:crud Tenancy OrganisationConfigFinancial --force
php artisan app:crud Tenancy OrganisationConfigMember --force
php artisan app:crud Tenancy OrganisationConfigSubscription --force

# Shared Domain
php artisan app:crud Shared Country --force
php artisan app:crud Shared Zone --force
php artisan app:crud Shared Lookup --force

# Products Domain
php artisan app:crud Products Product --force
php artisan app:crud Products ProductCategory --force
php artisan app:crud Products ProductOption --force
php artisan app:crud Products ProductOptionVariant --force
php artisan app:crud Products ProductImage --force
php artisan app:crud Products ProductEventRule --force
php artisan app:crud Products ProductRecurringRule --force

# Orders Domain
php artisan app:crud Orders Order --force
php artisan app:crud Orders OrderItem --force

# Subscriptions Domain
php artisan app:crud Subscriptions Subscription --force
php artisan app:crud Subscriptions SubscriptionAutoRenewal --force
php artisan app:crud Subscriptions SubscriptionPriceOption --force
php artisan app:crud Subscriptions SubscriptionPriceRenewal --force
php artisan app:crud Subscriptions SubscriptionPriceLateFee --force

# Financial Domain
php artisan app:crud Financial Invoice --force
php artisan app:crud Financial InvoiceLine --force
php artisan app:crud Financial Payment --force
php artisan app:crud Financial PaymentMethod --force
php artisan app:crud Financial TaxRate --force
php artisan app:crud Financial Vat --force
php artisan app:crud Financial AccountingCode --force

# Content Domain
php artisan app:crud Content Article --force
php artisan app:crud Content ArticleCategory --force
php artisan app:crud Content ArticleTag --force
php artisan app:crud Content Faq --force
php artisan app:crud Content FaqCategory --force
php artisan app:crud Content FaqTag --force
php artisan app:crud Content Document --force
php artisan app:crud Content Email --force
php artisan app:crud Content EmailTemplate --force

# Forms Domain
php artisan app:crud Forms VirtualForm --force
php artisan app:crud Forms VirtualField --force
php artisan app:crud Forms VirtualRecord --force
```

### 3. Update API Routes

Edit `routes/api.php` and add:

```php
<?php

use Illuminate\Support\Facades\Route;

// Include domain routes
require __DIR__.'/Members.php';
require __DIR__.'/Tenancy.php';
require __DIR__.'/Products.php';
require __DIR__.'/Orders.php';
require __DIR__.'/Subscriptions.php';
require __DIR__.'/Financial.php';
require __DIR__.'/Content.php';
require __DIR__.'/Forms.php';
require __DIR__.'/Shared.php';
```

### 4. Create Route Files for New Domains

```bash
# Create empty route files for new domains (if they don't exist)
New-Item -ItemType File -Path "routes/Shared.php" -Force
New-Item -ItemType File -Path "routes/Products.php" -Force
New-Item -ItemType File -Path "routes/Orders.php" -Force
New-Item -ItemType File -Path "routes/Subscriptions.php" -Force
New-Item -ItemType File -Path "routes/Financial.php" -Force
New-Item -ItemType File -Path "routes/Content.php" -Force
New-Item -ItemType File -Path "routes/Forms.php" -Force
```

Add PHP opening tag to each:
```php
<?php

// Routes will be auto-generated here
```

### 5. Run Migrations

```bash
# Fresh migration (WARNING: drops all tables)
php artisan migrate:fresh

# Or regular migration
php artisan migrate
```

### 6. Test API Endpoints

```bash
# List members
curl http://localhost:8000/api/members

# Create organisation
curl -X POST http://localhost:8000/api/organisations \
  -H "Content-Type: application/json" \
  -d '{"name":"Test Org","seo_name":"test-org","email":"test@org.com"}'
```

## What Gets Generated Per Entity

For each entity, the command creates:

### Files Created:
```
app/
├── Domains/{Domain}/
│   ├── Models/{Entity}.php
│   ├── Repositories/{Entity}Repository.php
│   ├── Actions/
│   │   ├── Create{Entity}.php
│   │   └── Update{Entity}.php
│   ├── Policies/{Entity}Policy.php
│   └── Events/{EventName}.php
├── Http/
│   ├── Controllers/{Domain}/{Entity}Controller.php
│   └── Requests/
│       ├── Store{Entity}Request.php
│       └── Update{Entity}Request.php

database/migrations/create_{table}_table.php
routes/{Domain}.php (appends route)
```

## Verify Generation

After running the commands, check:

```bash
# Count generated models
(Get-ChildItem -Recurse app/Domains/*/Models/*.php).Count

# Count generated controllers
(Get-ChildItem -Recurse app/Http/Controllers/*/Controller.php).Count

# Count migrations
(Get-ChildItem database/migrations/create_*.php).Count

# List all routes
php artisan route:list
```

## Common Issues

### Issue: "Domain JSON not found"
**Solution**: Ensure JSON file exists in `domains/` folder with lowercase name matching the domain parameter.

### Issue: "Entity not found in domain"
**Solution**: Check entity name matches exactly (case-sensitive) in the JSON file.

### Issue: Duplicate routes
**Solution**: The new command prevents duplicates. If you have old duplicates, manually edit the route file.

### Issue: Migration already exists
**Solution**: Delete old migration or use `--force` flag. The command deletes old migrations automatically.

### Issue: Class not found errors
**Solution**: Run `composer dump-autoload` after generating new classes.

## Next Steps After Generation

1. **Seeders**: Create seeders for base data (countries, lookups, etc.)
2. **Tests**: Write feature tests for each domain
3. **Authentication**: Implement user authentication
4. **Authorization**: Test policies work correctly
5. **Frontend**: Connect to your frontend application

## PowerShell One-Liner to Generate All

```powershell
@('Members Member','Members Address','Members Contact','Tenancy Organisation','Tenancy OrganisationConfig','Tenancy OrganisationRole','Tenancy OrganisationList','Tenancy OrganisationConfigAdmin','Tenancy OrganisationConfigFinancial','Tenancy OrganisationConfigMember','Tenancy OrganisationConfigSubscription','Shared Country','Shared Zone','Shared Lookup','Products Product','Products ProductCategory','Products ProductOption','Products ProductOptionVariant','Products ProductImage','Products ProductEventRule','Products ProductRecurringRule','Orders Order','Orders OrderItem','Subscriptions Subscription','Subscriptions SubscriptionAutoRenewal','Subscriptions SubscriptionPriceOption','Subscriptions SubscriptionPriceRenewal','Subscriptions SubscriptionPriceLateFee','Financial Invoice','Financial InvoiceLine','Financial Payment','Financial PaymentMethod','Financial TaxRate','Financial Vat','Financial AccountingCode','Content Article','Content ArticleCategory','Content ArticleTag','Content Faq','Content FaqCategory','Content FaqTag','Content Document','Content Email','Content EmailTemplate','Forms VirtualForm','Forms VirtualField','Forms VirtualRecord') | ForEach-Object { $parts = $_ -split ' '; php artisan app:crud $parts[0] $parts[1] --force }
```

This will generate all 47 entities automatically!

## Estimated Time
- Generation: ~5 minutes for all 47 entities
- Migration: ~30 seconds
- **Total: ~6 minutes to full CRUD backend**

## Success Indicators

You know it worked when:
- ✅ No errors during generation
- ✅ `php artisan route:list` shows all API routes
- ✅ Migrations run successfully
- ✅ Can make API calls to endpoints
- ✅ ~47 models exist across 9 domains
- ✅ ~47 controllers exist
- ✅ ~47 migrations exist
