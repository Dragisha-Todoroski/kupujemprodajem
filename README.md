# kupujemprodajem

Laravel-based web application for a small marketplace for posting and viewing ads (like kupujemprodajem.com).

Users can register and log in as:

- **Customer**: Create, edit, and delete their own ads.
- **Admin**: Manage customers, categories, and all ads via an admin dashboard.

---

## Requirements / Recommendations

These are the software versions the project was developed and tested with. Using these versions is recommended for best stability, though the app may work with slightly different versions.

- **PHP**: 8.2.12 — recommended >= 8.1
- **Composer**: 2.8.10 — recommended >= 2.5
- **Node.js**: 22.18.0 — recommended >= 18
- **npm**: 10.9.1 — recommended >= 9
- **MySQL / MariaDB**: MariaDB 10.4.32 — recommended >= 10.4 (or MySQL >= 8.0)
- **Laravel**: 12.23.1 — recommended >= 12.x

---

## Features Implemented

### Authentication & Users

- Laravel **Breeze authentication** setup.
- Users table uses **UUID primary keys**.
- Role-based authorization:
  - `role` column in users table (`customer` by default, `admin` for admins)
  - `isAdmin()` and isCustomer() methods in **User** model
  - `IsAdmin` and `IsCustomer` middlewares for route protection
- **User views**:
  - Blade templates in `resources/views/auth` for login, register, and password reset
  - Admin users can manage all customers via `Admin\UserController`

---

### Customers

- `users` table with **UUID primary key**, `role` column (`customer` or `admin`)
- **Policies**:
  - `CustomerPolicy` ensures only admins can create/update/delete customers
- **Validation**:
  - `StoreCustomerRequest` and `UpdateCustomerRequest` with reusable traits (`CustomerRulesTrait`, `CustomerMessagesTrait`)
- **Service layer**:
  - `CustomerService` interface and `EloquentCustomerService` implementation
- **Controller layer**:
  - `ProfileController` allows customers to view and update their own profile
  - `Admin\UserController` handles customer management (CRUD)
- **Blade views**:
  - Profile views: `resources/views/profile/partials/`
  - Admin customer management views: `resources/views/admin/customers/`
    - `index.blade.php`, `create.blade.php`, `edit.blade.php`
- **Features**:
  - Admin can create, edit, delete customers
  - Customers can update personal info but cannot change roles
  - Password reset handled via Laravel’s built-in `password_resets` table

---

### Categories

- `categories` table with **UUID primary key** and `parent_id` for nested categories
- Recursive fetching via `allDescendantsRecursive()`
- **Policies**:
  - `CategoryPolicy` ensures only admins can create/update/delete categories
- **Validation**:
  - `StoreCategoryRequest` and `UpdateCategoryRequest` with reusable traits (`CategoryRulesTrait`, `CategoryMessagesTrait`)
- **Service layer**:
  - `CategoryService` interface and `EloquentCategoryService` implementation
- **Controller layer**:
  - `Admin\CategoryController` handles category management (CRUD)
- **Blade views**:
  - Frontend sidebar for listing categories: `resources/views/frontend/partials/categoriesSidebar.blade.php`
  - Admin category management views: `resources/views/admin/categories/`
    - `index.blade.php`, `create.blade.php`, `edit.blade.php`, `partials/categoryOption.blade.php`, `partials/categoryRow.blade.php`
- **Features**:
  - Admin can create, edit, delete categories
  - Prevents circular relationships (a category cannot be its own or its child's descendant)
  - Nested categories displayed recursively
  - Categories can be fetched with all descendants using `allDescendantsRecursive()`

---

### Ads

- `ads` table with **UUID primary key**, relations to `users` and `categories`
- `AdCondition` enum for ad conditions
- **Policies**:
  - `AdPolicy` ensures admins can manage all ads; customers manage only their own
- **Validation**:
  - `StoreAdRequest` and `UpdateAdRequest` with `AdRulesTrait` and `AdMessagesTrait`
- **Service layer**:
  - `AdService` interface and `EloquentAdService` implementation
  - Handles creation, updating, deletion, image uploads, eager-loading relationships
- **Controller layer**:
  - `Frontend\AdController`: index, category listings, show, create/update/delete for customers
  - `Admin\AdController`: full CRUD for admins
- **Blade views**:
  - Frontend ads views: `resources/views/frontend/ads/`
    - `index.blade.php`, `show.blade.php`, `create.blade.php`, `edit.blade.php`, `partials/adForm.blade.php`
  - Admin ads views: `resources/views/admin/ads/`
    - `index.blade.php`, `create.blade.php`, `edit.blade.php`
  - **Features**:
  - Admin can create, edit, delete all ads
  - Customers can create, edit, delete their own ads only
  - Ads can have images uploaded and associated with categories and users
  - Filter and sort ads by title, price, condition, category, or creation date
  - Pagination supported for frontend listings

---

### Seeders & Factories

- `AdminUserSeeder` generates a fixed admin account
- `CategorySeeder` & `CategoryFactory` generates levels of category nesting
- `AdSeeder` & `AdFactory` generate realistic ads linked to users and categories

---

### Database

- Migrations include `users`, `ads`, `categories`, `sessions`, `password_resets`
- UUID compatibility across tables

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
```

3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

4. Edit .env to configure DB credentials

```bash
DB_CONNECTION=mysql       # The type of your database (MySQL)
DB_HOST=127.0.0.1         # Your database host
DB_PORT=3306               # Database port (default MySQL port)
DB_DATABASE=your_database_name   # Name of the database you created
DB_USERNAME=your_database_username   # Database user
DB_PASSWORD=your_database_password   # Database password
```

5. Run DB migrations

```bash
php artisan migrate
```

6. Seed the database

```bash
php artisan db:seed
```

7. Create symbolic link for storage

```bash
php artisan storage:link
```

8. Run the app

```bash
npm run dev # for Vite frontend
php artisan server # for Laravel server backend

OR

npm run dev-all # all-in-one command
```