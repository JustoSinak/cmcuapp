# Database Optimization Plan

## 1. Add Missing Indexes
- [x] Add index on `user_id` in patients table migration
- [x] Check and add indexes on foreign keys in other migrations (consultations, factures, etc.)
- [x] Add composite index on `name` and `prenom` in patients for search

## 2. Optimize Queries in Controllers
- [x] Update PatientsController::search() to use eager loading
- [x] Update PatientsController::index() to use eager loading if needed
- [x] Add select() for specific columns where appropriate

## 3. Pagination and Transactions
- [x] Add pagination to PatientsController::index() (10 per page)
- [x] Add pagination to PatientsController::search() (10 per page)
- [x] Pass $patients to index view in PatientsController::index()
- [x] Wrap PatientsController::store() in DB::transaction()

## 4. Database Tuning
- [x] Review config/database.php for optimizations

## 5. Testing
- [ ] Test performance improvements after changes
