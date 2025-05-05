# deploy.ps1 - Script PowerShell pour Windows

# 1. Sauvegarde MySQL
Write-Host "Sauvegarde de la base de données..."
& "C:\xampp\mysql\bin\mysqldump.exe" -u root -p gestion_absences > "backup_$(Get-Date -Format 'yyyy-MM-dd').sql"

# 2. Copie des fichiers
$source = "C:\xampp\htdocs\PFA_project_TEST1\*"
$destination = "C:\xampp\htdocs\prod\PFA_project_TEST1"

Write-Host "Copie des fichiers vers $destination..."
if (!(Test-Path $destination)) {
    New-Item -ItemType Directory -Path $destination
}
Copy-Item -Path $source -Destination $destination -Recurse -Force

# 3. Permissions (optionnel sous Windows)
Write-Host "Configuration des permissions..."
icacls $destination /grant "IIS_IUSRS:(OI)(CI)F"

Write-Host "Déploiement terminé avec succès!"