# URL Shortener

A Laravel-based URL shortening service with role-based access control.

## Tech Stack

- PHP 8.2+
- Laravel 11
- MySQL
- Bootstrap 5

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL
- Git

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/rahulyts5/url-shortener.git
cd url-shortener
```

### 2. Install dependencies

```bash
composer install
```

### 3. Copy environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure database

Open `.env` file and update the database section:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=root
```

### 5. Create database

```bash
mysql -u root -e "CREATE DATABASE url_shortener;"
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Seed the database

```bash
php artisan db:seed
```

This will create one company and three users with different roles.

### 8. Start the server

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000/login`

---

## Test Credentials

| Role | Email | Password |
|------|-------|----------|
| SuperAdmin | superadmin@example.com | password |
| Admin | admin@example.com | password |
| Member | member@example.com | password |

---

## Role Permissions

| Action | SuperAdmin | Admin | Member |
|--------|-----------|-------|--------|
| Create short URL | No | Yes | Yes |
| View all URLs | Yes - all companies | Yes - own company only | Yes - own URLs only |
| Resolve short URL | Public | Public | Public |
| Invite Admin | Yes | Yes | No |
| Invite Member | No | Yes | No |

---

## Features

- Role-based access control (SuperAdmin, Admin, Member)
- URL shortening with unique short codes
- Click count tracking
- Public URL resolution
- User invitation system
- Single company system

---

## Running Tests

```bash
php artisan test
```

Tests cover:
- Admin and Member can create short URLs
- SuperAdmin cannot create short URLs
- Admin can only see URLs from their own company
- Member can only see URLs created by themselves
- Short URLs are publicly resolvable

---

## Project Structure

```
app/
  Http/
    Controllers/
      AuthController.php       - Login and logout
      ShortUrlController.php   - URL shortener CRUD
      InvitationController.php - User invitations
    Middleware/
      RoleMiddleware.php       - Role-based route protection
  Models/
    User.php
    Company.php
    ShortUrl.php
    Invitation.php
  Policies/
    ShortUrlPolicy.php         - URL access policies
database/
  migrations/                  - All database migrations
  seeders/
    CompanySeeder.php          - Seeds one company
    UserSeeder.php             - Seeds users for all roles
routes/
  web.php                      - All application routes
resources/
  views/
    layouts/
      app.blade.php            - Main layout with Bootstrap
    auth/
      login.blade.php          - Login page
    urls/
      index.blade.php          - URL list page
      create.blade.php         - Create URL page
    invitations/
      create.blade.php         - Invite user page
    dashboard.blade.php        - Dashboard page
```

---

## AI Tools Used

- Helped explain Laravel authorization logic
- Helped understand custom middleware implementation
The project architecture, middleware logic, authorization flow, and implementation decisions were manually developed and reviewed.
