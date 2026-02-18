// Auth Types
export interface User {
  id: number;
  organisationId: number;
  email: string;
  name: string;
  isActive: boolean;
  emailVerifiedAt: string | null;
  lastLoginAt: string | null;
  createdAt: string;
  updatedAt: string;
  organisation?: Organisation;
}

export interface Organisation {
  id: number;
  name: string;
  seoName: string;
  email: string;
  phone: string;
  logo: string | null;
  website: string | null;
  description: string | null;
  freeTrail: boolean;
  freeTrailEndDate: string;
  billingPolicy: string;
  isActive: boolean;
  createdAt: string;
  updatedAt: string;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface LoginResponse {
  user: User;
  organisation: Organisation;
  token: {
    accessToken: string;
    expiresIn: string;
  };
}

export interface RegisterRequest {
  email: string;
  password: string;
  firstName: string;
  lastName: string;
  organisationId: number;
}
