# PostgreSQL Setup Guide for Membi

## ✅ PostgreSQL is Installed!

You have PostgreSQL 18 installed but it's currently stopped.

---

## 🚀 Quick Start Options

### Option 1: Start PostgreSQL Service (Requires Admin)

**Right-click PowerShell** → **Run as Administrator**, then:

```powershell
Start-Service postgresql-x64-18
Get-Service postgresql-x64-18
```

Or run this script as admin:
```powershell
.\start-postgres.ps1
```

---

### Option 2: Use Docker PostgreSQL

If you have Docker installed:

```bash
docker run --name membi-postgres -e POSTGRES_PASSWORD=postgres -e POSTGRES_DB=membi -p 5432:5432 -d postgres:16
```

Then update your `.env`:
```env
DATABASE_URL="postgresql://postgres:postgres@localhost:5432/membi?schema=public"
```

---

## 🔧 Configure Database Connection

After starting PostgreSQL, you need to configure your connection in `.env`:

### 1. Find Your PostgreSQL Credentials

Default PostgreSQL credentials are usually:
- **Username**: `postgres`
- **Password**: Whatever you set during installation
- **Host**: `localhost`
- **Port**: `5432`

### 2. Update `.env` File

Edit `nestjs/.env`:

```env
DATABASE_URL="postgresql://postgres:YOUR_PASSWORD@localhost:5432/membi?schema=public"
```

Replace `YOUR_PASSWORD` with your actual PostgreSQL password.

### 3. Create Database (If Needed)

Connect to PostgreSQL and create the database:

```bash
# Using psql command line
psql -U postgres
CREATE DATABASE membi;
\q
```

Or let Prisma create it automatically (it will if it doesn't exist).

---

## 🎯 Once PostgreSQL is Running

```bash
# 1. Generate Prisma client
npm run prisma:generate

# 2. Run migrations (creates tables)
npm run prisma:migrate

# 3. Seed test data
npm run prisma:seed

# 4. Start your API
npm run start:dev
```

---

## ❓ Troubleshooting

### Can't Remember PostgreSQL Password?

**Windows**: You may need to reset it. Check:
```
C:\Program Files\PostgreSQL\18\data\pg_hba.conf
```

Or reinstall PostgreSQL from: https://www.postgresql.org/download/windows/

### PostgreSQL Won't Start?

Check Windows Event Viewer for PostgreSQL errors:
```powershell
Get-EventLog -LogName Application -Source PostgreSQL -Newest 10
```

### Prefer SQLite for Development?

You can temporarily use SQLite (easier setup, no server needed):

1. Update `prisma/schema.prisma`:
```prisma
datasource db {
  provider = "sqlite"
  url      = "file:./dev.db"
}
```

2. Update `.env`:
```env
DATABASE_URL="file:./dev.db"
```

3. Install SQLite dependency:
```bash
npm install @prisma/client
```

4. Run migrations:
```bash
npm run prisma:migrate
```

---

## 🆘 Need Help?

Let me know which option you'd like to proceed with:
1. Start PostgreSQL service (needs admin)
2. Use Docker PostgreSQL
3. Use SQLite for now
4. Configure existing PostgreSQL

