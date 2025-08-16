# kupujemprodajem

Laravel-based web application for a small marketplace about posting and viewing ads (like kupujemprodajem.com).

Users can register and log in as:

- **Customer**: Create, edit, and delete their own ads.
- **Admin**: Manage customers, categories, and all ads via an admin dashboard.

---

## Features Implemented So Far

- Laravel project setup with **Breeze authentication**.
- **UUID primary keys** for `users` table.
- **Role-based system**:
  - `role` column in users table (`customer` by default, `admin` for admins)
  - `isAdmin()` method in User model.
- **Admin seeder** created (`AdminUserSeeder`) to generate a fixed admin account.
- `sessions` and `password_reset_tokens` tables migrated and compatible with UUID users.
- Basic User model setup with UUID generation in `boot()` method.
- **Category system**:
  - `categories` table with UUID primary key and `parent_id` for nested categories.
  - `Category` model with UUID generation and parent/children relationships.
  - `CategorySeeder` with 3 levels of category nesting.
  - Recursive fetching of all nested descendants via `allDescendantsRecursive()` method.
  - **Validation and business rules**:
    - Prevents circular relationships (a category cannot be its own or its child's descendant).
    - Validation handled in `StoreCategoryRequest` and `UpdateCategoryRequest` using reusable traits (`CategoryRulesTrait` and `CategoryMessagesTrait`).
  - **Admin-only management**:
    - `CategoryPolicy` ensures only admin users can create, edit, update, or delete categories.
    - `descendantsKeys()` helps enforce safe category updates.
  - **Service layer**:
    - `CategoryService` interface defines standard methods for category operations.
    - `EloquentCategoryService` implements `CategoryService`, including recursive fetching of categories.


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