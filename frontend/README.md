# Membi Frontend

Club Member Management System - Frontend built with Next.js and PrimeReact

## Tech Stack

- **Next.js 15** - React framework with App Router
- **TypeScript** - Type-safe development
- **PrimeReact** - UI component library
- **Tailwind CSS** - Utility-first CSS framework
- **PrimeIcons** - Icon library
- **PrimeFlex** - CSS utility library

## Getting Started

### Prerequisites

- Node.js 18+ installed
- Backend API running on http://localhost:3000

### Development

```bash
npm run dev
```

Open [http://localhost:3001](http://localhost:3001) in your browser.

### Build for Production

```bash
npm run build
npm start
```

## Login Credentials

```
Email: admin@testorg.com
Password: password123
```

## Project Structure

```
frontend/
├── app/
│   ├── dashboard/          # Dashboard page (protected)
│   ├── login/              # Login page
│   ├── globals.css         # Global styles + PrimeReact theme
│   ├── layout.tsx          # Root layout
│   ├── page.tsx            # Home page (redirects)
│   └── providers.tsx       # Client-side providers
├── lib/
│   ├── api-client.ts       # HTTP client with auth
│   ├── auth-service.ts     # Authentication service
│   ├── auth-context.tsx    # Auth context & hooks
│   └── types/
│       └── auth.ts         # TypeScript types
└── .env.local              # Environment variables
```

## Features Implemented

### Authentication
- ✅ Login with JWT tokens
- ✅ Auto token storage
- ✅ Protected routes
- ✅ Auth context with hooks

### API Integration
- ✅ Type-safe API client
- ✅ Automatic token injection
- ✅ Error handling

## Usage Examples

### Using Auth Hook

```tsx
import { useAuth } from '@/lib/auth-context';

const { user, organisation, logout } = useAuth();
```

### Making API Calls

```tsx
import { apiClient } from '@/lib/api-client';

const data = await apiClient.get('/members');
```

## Resources

- [PrimeReact Docs](https://primereact.org/)
- [Next.js Docs](https://nextjs.org/docs)

## Deploy on Vercel

The easiest way to deploy your Next.js app is to use the [Vercel Platform](https://vercel.com/new?utm_medium=default-template&filter=next.js&utm_source=create-next-app&utm_campaign=create-next-app-readme) from the creators of Next.js.

Check out our [Next.js deployment documentation](https://nextjs.org/docs/app/building-your-application/deploying) for more details.
