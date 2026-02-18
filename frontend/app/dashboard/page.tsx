"use client";

import { useEffect } from "react";
import { useRouter } from "next/navigation";
import { useAuth } from "@/lib/auth-context";
import { Card } from "primereact/card";
import { Button } from "primereact/button";
import { Avatar } from "primereact/avatar";

export default function DashboardPage() {
  const { user, organisation, isLoading, isAuthenticated, logout } = useAuth();
  const router = useRouter();

  useEffect(() => {
    if (!isLoading && !isAuthenticated) {
      router.push("/login");
    }
  }, [isLoading, isAuthenticated, router]);

  if (isLoading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <i className="pi pi-spin pi-spinner text-4xl text-blue-500" />
      </div>
    );
  }

  if (!user) {
    return null;
  }

  return (
    <div className="min-h-screen bg-gray-100">
      {/* Header */}
      <div className="bg-white shadow">
        <div className="container mx-auto px-4 py-4 flex justify-between items-center">
          <div className="flex items-center gap-3">
            <h1 className="text-2xl font-bold text-gray-800">
              {organisation?.name || "Membi"}
            </h1>
          </div>
          <div className="flex items-center gap-4">
            <div className="flex items-center gap-2">
              <Avatar
                label={user.name?.[0]?.toUpperCase() || "U"}
                size="large"
                shape="circle"
                className="bg-blue-500 text-white"
              />
              <div className="hidden md:block">
                <div className="font-semibold">{user.name}</div>
                <div className="text-sm text-gray-600">{user.email}</div>
              </div>
            </div>
            <Button
              label="Logout"
              icon="pi pi-sign-out"
              severity="danger"
              outlined
              onClick={logout}
            />
          </div>
        </div>
      </div>

      {/* Main Content */}
      <div className="container mx-auto px-4 py-8">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <Card title="Welcome!" className="shadow-lg">
            <p className="text-gray-700">
              You are now logged in to the Membi platform.
            </p>
            <p className="text-sm text-gray-600 mt-2">
              Organisation: {organisation?.name}
            </p>
          </Card>

          <Card title="Quick Stats" className="shadow-lg">
            <div className="flex flex-col gap-2">
              <div>
                <span className="font-semibold">Status:</span>{" "}
                <span
                  className={user.isActive ? "text-green-600" : "text-red-600"}
                >
                  {user.isActive ? "Active" : "Inactive"}
                </span>
              </div>
              <div>
                <span className="font-semibold">Last Login:</span>{" "}
                <span className="text-sm">
                  {user.lastLoginAt
                    ? new Date(user.lastLoginAt).toLocaleString()
                    : "Never"}
                </span>
              </div>
            </div>
          </Card>

          <Card title="Getting Started" className="shadow-lg">
            <p className="text-gray-700">Your backend API is running at:</p>
            <code className="block mt-2 p-2 bg-gray-100 rounded text-sm">
              {process.env.NEXT_PUBLIC_API_URL}
            </code>
            <Button
              label="View API Docs"
              icon="pi pi-external-link"
              className="mt-4"
              onClick={() =>
                window.open("http://localhost:3000/api/docs", "_blank")
              }
            />
          </Card>
        </div>
      </div>
    </div>
  );
}
