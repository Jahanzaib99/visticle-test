# Visticle - Task Management System

A mini event-based task management system built with Laravel, featuring authentication, role-based access control, event-driven architecture, and REST API.

## Features

- User authentication and registration
- Role-based access control (Admin and User)
- Task CRUD operations
- Event-driven architecture with Laravel Events & Listeners
- Queue system for background jobs
- REST API with Sanctum authentication
- Email notifications for task events
- Task logging system

## Requirements

- PHP >= 8.2
- Composer
- MySQL/PostgreSQL/SQLite
- Node.js and NPM (for frontend assets)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd visticle
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install frontend dependencies:
```bash
npm install
```

4. Copy environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visticle
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Configure queue connection in `.env`:
```env
QUEUE_CONNECTION=database
```

8. Configure mail settings in `.env` (for email notifications):
```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

9. Run migrations:
```bash
php artisan migrate
```

10. Seed the database:
```bash
php artisan db:seed
```

11. Build frontend assets:
```bash
npm run build
```

## Queue Setup

This application uses database queues for background job processing. To process queued jobs, run:

```bash
php artisan queue:work
```

Or use a process manager like Supervisor for production environments.

## Default Users

After seeding, you can login with:

- **Admin User:**
  - Email: `admin@example.com`
  - Password: `password`

- **Regular User:**
  - Email: `user@example.com`
  - Password: `password`

## API Documentation

### Authentication

#### Login
```
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "message": "Login successful",
    "token": "1|xxxxxxxxxxxx",
    "user": {
        "id": 1,
        "name": "User Name",
        "email": "user@example.com",
        "role": "user"
    }
}
```

#### Logout
```
POST /api/logout
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Logged out successfully"
}
```

### Tasks

All task endpoints require authentication via Sanctum token.

#### Get All Tasks
```
GET /api/tasks
Authorization: Bearer {token}
```

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Task Title",
            "description": "Task description",
            "status": "pending",
            "due_date": "2024-12-31",
            "created_by": 1,
            "created_at": "2024-12-29T00:00:00.000000Z",
            "updated_at": "2024-12-29T00:00:00.000000Z",
            "creator": {
                "id": 1,
                "name": "User Name",
                "email": "user@example.com"
            }
        }
    ]
}
```

**Note:** Regular users see only their own tasks. Admins see all tasks.

#### Create Task
```
POST /api/tasks
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "New Task",
    "description": "Task description",
    "status": "pending",
    "due_date": "2024-12-31"
}
```

**Response:**
```json
{
    "message": "Task created successfully",
    "data": {
        "id": 1,
        "title": "New Task",
        "description": "Task description",
        "status": "pending",
        "due_date": "2024-12-31",
        "created_by": 1,
        "created_at": "2024-12-29T00:00:00.000000Z",
        "updated_at": "2024-12-29T00:00:00.000000Z",
        "creator": {
            "id": 1,
            "name": "User Name",
            "email": "user@example.com"
        }
    }
}
```

#### Update Task
```
PUT /api/tasks/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Updated Task",
    "status": "completed"
}
```

**Response:**
```json
{
    "message": "Task updated successfully",
    "data": {
        "id": 1,
        "title": "Updated Task",
        "status": "completed",
        ...
    }
}
```

#### Delete Task
```
DELETE /api/tasks/{id}
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Task deleted successfully"
}
```

### Status Codes

- `200` - Success
- `201` - Created
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error

## Events and Listeners

### TaskCreated Event

Triggered when a task is created.

**Listeners:**
- `SendTaskCreatedNotification` - Sends email notification (queued)
- `LogTaskCreated` - Logs the event in `task_logs` table

### TaskCompleted Event

Triggered when a task status changes to "completed".

**Listeners:**
- `SendTaskCompletedNotification` - Dispatches `SendTaskCompletionJob` (queued)
- `LogTaskCompleted` - Logs the event in `task_logs` table

## Database Structure

### Users Table
- `id` - Primary key
- `name` - User name
- `email` - User email (unique)
- `password` - Hashed password
- `role` - Enum: 'admin' or 'user'
- `timestamps`

### Tasks Table
- `id` - Primary key
- `title` - Task title
- `description` - Task description (nullable)
- `status` - Enum: 'pending', 'in_progress', 'completed'
- `due_date` - Due date (nullable)
- `created_by` - Foreign key to users table
- `timestamps`

### Task Logs Table
- `id` - Primary key
- `task_id` - Foreign key to tasks table
- `event_type` - Event type (e.g., 'task_created', 'task_completed')
- `description` - Log description
- `timestamps`

## Running the Application

1. Start the development server:
```bash
php artisan serve
```

2. In a separate terminal, start the queue worker:
```bash
php artisan queue:work
```

3. Access the application at `http://localhost:8000`

## Testing

Run the test suite:
```bash
php artisan test
```

## Code Standards

This project follows PSR-12 coding standards. Code formatting can be applied using:

```bash
./vendor/bin/pint
```

## License

This project is created for assignment purposes.
