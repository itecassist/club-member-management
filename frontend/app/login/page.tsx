"use client";

import { useState } from "react";
import { useAuth } from "@/lib/auth-context";
import { InputText } from "primereact/inputtext";
import { Password } from "primereact/password";
import { Button } from "primereact/button";
import { Card } from "primereact/card";
import { Message } from "primereact/message";

export default function LoginPage() {
  const [email, setEmail] = useState("admin@testorg.com");
  const [password, setPassword] = useState("password123");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const { login } = useAuth();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      await login({ email, password });
    } catch (err: any) {
      setError(err.message || "Login failed");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <Card className="w-full max-w-md p-6 shadow-lg">
        <div className="text-center mb-6">
          <h1 className="text-3xl font-bold text-gray-800">Membi</h1>
          <p className="text-gray-600 mt-2">Club Member Management</p>
        </div>

        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
          {error && <Message severity="error" text={error} />}

          <div className="flex flex-col gap-2">
            <label htmlFor="email" className="font-semibold">
              Email
            </label>
            <InputText
              id="email"
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="Enter your email"
              required
              disabled={loading}
            />
          </div>

          <div className="flex flex-col gap-2">
            <label htmlFor="password" className="font-semibold">
              Password
            </label>
            <Password
              id="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              placeholder="Enter your password"
              feedback={false}
              toggleMask
              required
              disabled={loading}
            />
          </div>

          <Button
            type="submit"
            label={loading ? "Signing in..." : "Sign In"}
            icon={loading ? "pi pi-spin pi-spinner" : "pi pi-sign-in"}
            loading={loading}
            className="mt-4"
          />
        </form>

        <div className="text-center mt-4 text-sm text-gray-600">
          <p>Test Credentials:</p>
          <p>admin@testorg.com / password123</p>
        </div>
      </Card>
    </div>
  );
}
