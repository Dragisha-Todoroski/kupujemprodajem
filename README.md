# kupujemprodajem

Laravel-based web application for a small marketplace about posting and viewing ads (like kupujemprodajem.com).

Users can register and log in as:

- **Customer**: Create, edit, and delete their own ads.
- **Admin**: Manage customers, categories, and all ads via an admin dashboard.

---

## Features Implemented So Far

- Laravel project setup with **Breeze authentication**.
- **UUID primary keys** for `users` table.
  - **Role-based authorization management**:
    - `AdPolicy` ensures only admin users create, update, or delete ads, and customer users their own.
    - `CategoryPolicy` ensures only admin users can create, update, or delete categories.
    - Custom `IsAdmin` and `IsCustomer` middlewares for additional admin/customer authorization checks.
    - `role` column in users table (`customer` by default, `admin` for admins)
    - `isAdmin()` method in User model.
- **Category system**:
  - `categories` table with UUID primary key and `parent_id` for nested categories.
  - `Category` model with UUID generation and parent/children relationships.
  - Recursive fetching of all nested descendants via `allDescendantsRecursive()` method.
  - `descendantsKeys()` helps enforce safe category updates.
  - **Validation and business rules**:
    - Prevents circular relationships (a category cannot be its own or its child's descendant).
    - Validation handled in `StoreCategoryRequest` and `UpdateCategoryRequest` using reusable traits (`CategoryRulesTrait` and `CategoryMessagesTrait`).
  - **Service layer**:
    - `CategoryService` interface defines standard methods for category operations.
    - `EloquentCategoryService` implements `CategoryService`, including recursive fetching of categories.
  - **Controller layer**:
    - `Admin\CategoryController` for admin CRUD on categories.
- **Ads system**:
  - `ads` table with UUID primary key, and relations to `users` and `categories`.
  - `Ad` model with UUID generation and relationships to `User` and `Category`.
  - **Validation and business rules**:
    - Validation handled in `StoreAdRequest` and `UpdateAdRequest` using reusable traits (`AdRulesTrait` and `AdMessagesTrait`).
  - **Service layer**:
    - `AdService` interface defines standard methods for ad operations (getAll, create, update, delete, search).
    - `EloquentAdService` implements `AdService`, handling all business logic including image uploads and eager-loading relationships.
  - **Controller layer**:
    - `Frontend\AdController` for guest and customer access:
      - Index with filters and pagination.
      - Category-specific listings.
      - Show single ad.
      - Authenticated customers can create, update, and delete their own ads.
    - `Admin\AdController` for admin access:
      - Full CRUD on all ads (index, create, store, edit, update, delete).
      - No `show` route for admin views.
- **Seeders and Factories for realistic fake data**:
  - `AdminUserSeeder` to generate a fixed admin account.
  - `CategorySeeder` based on `CategoryFactory` with 3 levels of category nesting.
  - `AdSeeder` based on `AdFactory` using random existing users and categories.
- `sessions` and `password_reset_tokens` tables migrated and compatible with UUID users.
- Basic User model setup with UUID generation in `boot()` method.

---

## Installation / Setup

1. Clone the repository:

```bash
git clone <repo-url> kupujemprodajem
cd kupujemprodajem\
```

2. Install dependencies:

```bash
composer install
npm install
npm run dev
```

3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

4. Edit .env to configure DB credentials

5. Run DB migrations

```bash
php artisan migrate
```

6. Seed the database

```bash
php artisan db:seed
```