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
  - `categories` table with UUID primary key and `parent_id` for nested categories
  - `Category` model with UUID generation and parent/children relationships
  - `CategorySeeder` with 3 levels of category nesting

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