"use client";

import { PrimeReactProvider } from "primereact/api";
import { AuthProvider } from "@/lib/auth-context";

export function Providers({ children }: { children: React.ReactNode }) {
  return (
    <PrimeReactProvider>
      <AuthProvider>{children}</AuthProvider>
    </PrimeReactProvider>
  );
}
