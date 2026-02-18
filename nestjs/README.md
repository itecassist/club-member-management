# Membi API - Membership Management Platform

Modern membership management platform built with NestJS, Prisma, and PostgreSQL.

## Tech Stack

- **Framework**: NestJS (TypeScript)
- **ORM**: Prisma
- **Database**: PostgreSQL
- **Authentication**: JWT with Passport
- **Architecture**: Domain-Driven Design (DDD)
- **API Documentation**: Swagger/OpenAPI

## Features

- 🏢 **Multi-Tenancy**: Single-database with organization scoping
- 👥 **Member Management**: Comprehensive member profiles with polymorphic addresses/contacts
- 💳 **Subscriptions**: Flexible subscription plans with multiple payment periods
- 🛒 **Orders & Payments**: Complete e-commerce with invoice generation
- 📝 **Content Management**: Articles, FAQs, and document management
- 📋 **Dynamic Forms**: Virtual forms with custom field definitions
- 🔐 **JWT Authentication**: Secure token-based authentication
- 🎯 **Role-Based Access**: Organization-specific roles and permissions

## Getting Started

### Prerequisites

- Node.js 18+ and npm/pnpm
- PostgreSQL 14+
- Git

### Installation

1. Install dependencies:
```bash
npm install
```

2. Set up environment variables:
```bash
cp .env.example .env
# Edit .env with your database credentials
```

3. Generate Prisma schema from domain JSONs:
```bash
npm run generate:domain
```

4. Generate Prisma client and run migrations:
```bash
npm run prisma:generate
npm run prisma:migrate
```

5. Seed the database (optional):
```bash
npm run prisma:seed
```

6. Start the development server:
```bash
npm run start:dev
```

The API will be available at `http://localhost:3000`

Swagger documentation: `http://localhost:3000/api/docs`

## Development

### Generate New Domain Module

The project uses JSON specifications to auto-generate CRUD modules:

```bash
npm run generate:domain -- --domain Members --entity Member
```

This generates:
- Prisma model
- NestJS module
- Controller with CRUD endpoints
- Service with business logic
- DTOs with validation
- Repository pattern

### Run Tests

```bash
# Unit tests
npm run test

# E2E tests
npm run test:e2e

# Test coverage
npm run test:cov
```

### Database Management

```bash
# Create migration
npm run prisma:migrate

# View database in Prisma Studio
npm run prisma:studio

# Reset database
npx prisma migrate reset
```

## License

Proprietary - All rights reserved
