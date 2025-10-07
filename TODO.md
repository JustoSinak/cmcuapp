# TODO: Fix 7php artisan serve error and TrustProxies middleware

## Tasks
- [x] Update app/Http/Middleware/TrustProxies.php to use correct Illuminate class and set proxies
- [ ] Move project to local drive (e.g., C:\cmcuapp) to resolve UNC path issue with php artisan serve
- [ ] Test php artisan serve from local drive
- [ ] If needed, configure XAMPP Apache for network share alternative

## Notes
- The "Unable to launch a new process" error is due to project being on UNC path on Windows.
- TrustProxies middleware has outdated class reference.
