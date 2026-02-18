import { apiClient } from "./api-client";
import type {
  LoginRequest,
  LoginResponse,
  RegisterRequest,
  User,
} from "./types/auth";

// Auth Service
export const authService = {
  async login(credentials: LoginRequest): Promise<LoginResponse> {
    const response = await apiClient.post<LoginResponse>(
      "/auth/login",
      credentials,
    );

    // Store token
    apiClient.setToken(response.token.accessToken);

    return response;
  },

  async register(data: RegisterRequest): Promise<LoginResponse> {
    const response = await apiClient.post<LoginResponse>(
      "/auth/register",
      data,
    );

    // Store token
    apiClient.setToken(response.token.accessToken);

    return response;
  },

  async getProfile(): Promise<User> {
    return apiClient.get<User>("/auth/profile");
  },

  async logout(): Promise<void> {
    // Clear token
    apiClient.setToken(null);
  },

  isAuthenticated(): boolean {
    return !!apiClient.getToken();
  },

  getToken(): string | null {
    return apiClient.getToken();
  },
};
