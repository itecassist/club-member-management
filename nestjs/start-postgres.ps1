# Start PostgreSQL Service
# Run this script as Administrator

Write-Host "Starting PostgreSQL service..." -ForegroundColor Cyan

try {
    Start-Service postgresql-x64-18 -ErrorAction Stop
    Write-Host "✓ PostgreSQL started successfully!" -ForegroundColor Green
    
    $service = Get-Service postgresql-x64-18
    Write-Host "`nService Status: $($service.Status)" -ForegroundColor Yellow
    
    Write-Host "`nYou can now run:" -ForegroundColor Cyan
    Write-Host "  cd D:\Projects\club-member-management\nestjs"
    Write-Host "  npm run prisma:migrate"
}
catch {
    Write-Host "✗ Failed to start PostgreSQL" -ForegroundColor Red
    Write-Host "Error: $_" -ForegroundColor Red
    Write-Host "`nPlease ensure:" -ForegroundColor Yellow
    Write-Host "  1. You're running PowerShell as Administrator"
    Write-Host "  2. PostgreSQL is properly installed"
}
