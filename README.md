<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Backend Assessment

A comprehensive Laravel application showcasing user management with role-based permissions, email notifications, and RESTful API endpoints.

## 🚀 Features

- **User Management API** with role-based access control
- **Email Notifications** for user registration
- **Search & Pagination** functionality
- **Database Factories & Seeders** for testing data
- **Role-based Authorization** (Admin, Manager, User)

## 📋 Requirements

- PHP 8.2+
- Composer
- PostgreSQL
- Laravel 11.x

## ⚡ Quick Start

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-backend-assessment
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Start the server**
   ```bash
   php artisan serve
   ```

## 🔗 API Endpoints

### 📝 Create User
**POST** `/api/users`

Creates a new user account and sends confirmation emails.

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (201):**
```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-10-22T10:30:00Z"
}
```

**Features:**
- ✅ Name validation (3-50 characters)
- ✅ Email validation (unique & format)
- ✅ Password validation (minimum 8 characters)
- ✅ Automatic email notifications to user & admin
---

### 👥 Get Users
**GET** `/api/users`

Retrieves paginated list of active users with role-based editing permissions.

**Query Parameters:**
- `search` (optional) - Search by name or email
- `page` (optional) - Page number for pagination
- `sortBy` (optional) - Sort by: `name`, `email`, `created_at`

**Examples:**
```bash
GET /api/users
GET /api/users?search=john
GET /api/users?sortBy=name&page=2
```

**Response (200):**
```json
{
    "page": 1,
    "users": [
        {
            "id": 1,
            "role": "user",
            "can_edit": true,
            "orders_count": 3,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2024-10-22T10:30:00Z"
        }
    ]
}
```

**Features:**
- ✅ Active users only
- ✅ Case-insensitive search
- ✅ Orders count for each user
- ✅ Pagination (10 users per page)
- ✅ Role-based `can_edit` permissions

---

## 🛡️ Role-Based Permissions

The `can_edit` field in the Get Users API response indicates whether the currently logged-in user has permission to edit each user. Since this assessment doesn't include authentication process, a **mocked user** is used for demonstration purposes.

### Current Mocked User
```php
$currentUser = [
    'id' => 1,
    'role' => 'admin',
];
```

### Testing Different Roles
You can modify the mocked user in `UserController@index()` to test different permission scenarios:

```php
// Test as Manager
$currentUser = ['id' => 2, 'role' => 'manager'];

// Test as Regular User  
$currentUser = ['id' => 3, 'role' => 'user'];
```

**Note:** In a production environment, this would be replaced with actual authentication middleware to get the real logged-in user.

---

## 📧 Email Notifications

### User Registration Emails
When a new user registers, two emails are automatically sent:

1. **Welcome Email** → Sent to the new user
2. **Admin Notification** → Sent to administrators

**Email Configuration:**
Set these variables in your `.env` file:
```env
MAIL_PORT=587
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PASSWORD=your-password
ADMIN_EMAIL=admin@example.com
MAIL_USERNAME=your-email@example.com
```

---

### API Testing
Use tools like Postman, Insomnia, or curl:

```bash
# Create a new user
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password123"}'

# Get users with search
curl "http://localhost:8000/api/users?search=admin&sortBy=name" \
  -H "Accept: application/json"
```

---

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).