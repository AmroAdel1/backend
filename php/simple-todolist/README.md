# Simple Todo List Application

A simple and elegant Laravel-based todo list management system with full CRUD (Create, Read, Update, Delete) operations, user authentication, and password recovery. Built with Laravel, Bootstrap 5, Font Awesome icons, modern UI components, and secure authentication features.

## Features

### ✅ Implemented Features

#### Authentication System
- **User Registration** - Create new user accounts with email verification
- **User Login** - Secure authentication with session management
- **User Logout** - Safe session termination
- **Password Reset** - Complete forgot password flow with email tokens
  - Request password reset via email
  - Reset password using secure token link
  - Update password functionality

#### Todo Management
- **Create Todos** - Add new todo items with title, description, due date, and priority
- **Read Todos** - View all your active todos with filtering options
- **Update Todos** - Edit existing todo items
- **Delete Todos** - Remove todos (soft delete for data recovery)
- **Toggle Complete** - Mark todos as complete/incomplete
- **Finished Todos Page** - Separate view for completed tasks
- **Priority Levels** - Organize todos by Low, Medium, or High priority
- **Due Dates** - Set deadlines for your tasks
- **Soft Deletes** - Deleted todos are recoverable

#### Security & Authorization
- Route protection with middleware (guest/auth)
- Policy-based authorization (users can only manage their own todos)
- CSRF protection on all forms
- Secure password hashing
- Token-based password reset

## Database Structure

### Users Table
```
users
├── id (Primary Key, Auto Increment)
├── name (VARCHAR)
├── email (VARCHAR, Unique)
├── email_verified_at (TIMESTAMP, Nullable)
├── password (VARCHAR)
├── remember_token (VARCHAR, Nullable)
├── created_at (TIMESTAMP)
└── updated_at (TIMESTAMP)
```

### Todos Table
```
todos
├── id (Primary Key, Auto Increment)
├── title (VARCHAR)
├── description (TEXT, Nullable)
├── due_date (DATETIME, Nullable)
├── is_completed (BOOLEAN, Default: false)
├── priority (ENUM: 'low', 'medium', 'high', Default: 'medium')
├── user_id (Foreign Key → users.id, Nullable)
├── terms (BOOLEAN, Default: false)
├── created_at (TIMESTAMP)
├── updated_at (TIMESTAMP)
└── deleted_at (TIMESTAMP, Nullable) # Soft Delete
```

### Password Reset Tokens Table
```
password_reset_tokens
├── email (VARCHAR, Primary Key)
├── token (VARCHAR)
└── created_at (TIMESTAMP)
```

### Relationship
- **One-to-Many**: One User can have many Todos
- **Foreign Key**: `todos.user_id` references `users.id`
- **Cascade Delete**: When a user is deleted, all their todos are automatically deleted

## Project Structure

```
project-root/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php           # Authentication logic
│   │       ├── TodoController.php           # Todo CRUD operations
│   │       └── ForgotPasswordController.php # Password reset logic
│   │
│   ├── Models/
│   │   ├── User.php                         # User model
│   │   └── Todo.php                         # Todo model with SoftDeletes
│   │
│   └── Policies/
│       └── TodoPolicy.php                   # Authorization rules for todos
│
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php              # Login form
│       │   ├── register.blade.php           # Registration form
│       │   ├── forgot-password.blade.php    # Request password reset
│       │   ├── reset-password.blade.php     # Reset password form
│       │   └── settings.blade.php           # User settings
│       │
│       └── todos/
│           ├── index.blade.php              # List all active todos
│           ├── create.blade.php             # Create new todo
│           ├── edit.blade.php               # Edit existing todo
│           ├── show.blade.php               # View todo details
│           └── finished.blade.php           # Completed todos list
│
├── routes/
│   └── web.php                              # Route definitions
│
└── database/
    └── migrations/
        ├── create_users_table.php
        ├── create_todos_table.php
        └── create_password_reset_tokens_table.php
```

## Routes Overview

### Guest Routes (Unauthenticated Users)
```php
GET  /login                  - Display login form
POST /login                  - Authenticate user
GET  /register               - Display registration form
POST /register               - Create new user account
GET  /forget-password        - Display password reset request form
POST /forget-password        - Send password reset email
GET  /reset-password/{token} - Display password reset form
POST /reset-password         - Update password
```

### Authenticated Routes
```php
POST   /logout                - Log out current user
GET    /settings              - User settings page
GET    /todos                 - List all active todos
POST   /todos                 - Create new todo
GET    /todos/create          - Show create todo form
GET    /todos/{id}            - View single todo
GET    /todos/{id}/edit       - Edit todo form
PUT    /todos/{id}            - Update todo
DELETE /todos/{id}            - Delete todo (soft delete)
PATCH  /todos/{id}/toggle     - Toggle todo completion status
GET    /todos/finished        - View completed todos
```

## Installation

### Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd simple-todo-list
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database in .env**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todo_db
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Configure mail settings** (for password reset)
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@todoapp.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   npm run dev
   ```

8. **Access the application**
   ```
   http://localhost:8000
   ```

## Usage Examples

### 1. Creating an Account
- Navigate to `/register`
- Enter your name, email, and password
- Accept terms and conditions
- Click "Register"
- You'll be automatically logged in

### 2. Logging In
- Navigate to `/login`
- Enter your email and password
- Click "Login"
- Access your personal todo dashboard

### 3. Creating a Todo
Navigate to `/todos/create` or click "Create New Todo" button:
- Enter a title (e.g., "Complete Laravel Project")
- Add a description (optional)
- Select priority level (Low, Medium, or High)
- Set a due date (optional)
- Click "Create Todo"

### 4. Viewing All Todos
Navigate to `/todos` to see a list with:
- Todo title and description
- Priority badge
- Due date
- Completion status
- Action buttons (View, Edit, Delete, Toggle Complete)

### 5. Completing a Todo
- Click the "Toggle Complete" button or checkbox
- Todo will be marked as completed
- Access completed todos via "Finished" page

### 6. Editing a Todo
- Click "Edit" button on any todo
- Modify the title, description, priority, or due date
- Click "Update Todo" to save changes

### 7. Deleting a Todo
- Click "Delete" button
- Confirm the deletion in the popup
- Todo will be soft-deleted (recoverable if needed)

### 8. Password Recovery
1. Click "Forgot Password?" on the login page
2. Enter your email address
3. Check your email for the reset link
4. Click the link and enter your new password
5. Login with your new credentials

## UI Features

- **Modern Design**: Clean and intuitive interface
- **Responsive Layout**: Works perfectly on desktop, tablet, and mobile
- **Priority Colors**: Visual indicators for Low (green), Medium (yellow), High (red)
- **Status Badges**: Clear completion status indicators
- **Form Validation**: Client and server-side validation
- **Confirmation Dialogs**: Safety prompts before deletion
- **Empty States**: Friendly messages when no todos exist
- **Flash Messages**: Success/error notifications

## Security Features

- **Authentication Required**: All todo operations require login
- **Authorization Policy**: Users can only manage their own todos
- **CSRF Protection**: All forms protected against cross-site attacks
- **Password Hashing**: Bcrypt encryption for passwords
- **Secure Password Reset**: Token-based reset with expiration
- **SQL Injection Protection**: Eloquent ORM prevents injection attacks

## 🚧 Known Limitations & Future Improvements

### Pending Features

#### 1. Responsive Design
- **Status**: Partially implemented
- **Issue**: Some pages may not be fully optimized for mobile devices
- **Todo**: Add responsive CSS for better mobile experience on all pages

#### 2. Terms & Privacy Pages
- **Status**: Not implemented
- **Location**: Register page
- **Todo**: Create terms of service and privacy policy blade templates
- **Files needed**:
  - `resources/views/auth/terms.blade.php`
  - `resources/views/auth/privacy.blade.php`
- **Routes needed**:
  ```php
  Route::get('/terms', function () {
      return view('auth.terms');
  })->name('terms');
  
  Route::get('/privacy', function () {
      return view('auth.privacy');
  })->name('privacy');
  ```

#### 3. User Settings Page
- **Status**: Route exists but functionality not implemented
- **Missing features**:
  - Avatar upload functionality
  - Profile picture display and storage
  - Image validation (size, type)
  - Profile information update (name, email)
  - Password change within settings
- **Route**: `/settings`
- **Required implementation**:
  - Add `avatar` column to users table
  - File upload handling in AuthController
  - Image storage configuration
  - Form for profile updates

#### 4. Social Authentication
- **Status**: Not implemented
- **Missing providers**:
  - "Continue with Google" login button
  - Google OAuth signup integration
- **Todo**: Implement Laravel Socialite for Google authentication
- **Required steps**:
  ```bash
  composer require laravel/socialite
  ```
- **Configuration needed**:
  - Google OAuth credentials in .env
  - Socialite routes and controller
  - Google provider setup

## Troubleshooting

### Common Issues

#### 1. Styling not working
- Clear browser cache: `Ctrl + Shift + Delete`
- Run `npm run dev` to compile assets
- Check if CSS/JS files are being loaded in browser console

#### 2. Todos not displaying
- Check database connection in `.env`
- Run `php artisan migrate` to ensure tables exist
- Verify you're logged in as the correct user
- Check if todos exist: `php artisan tinker` → `Todo::count()`

#### 3. Email not sending (Password Reset)
- Verify mail configuration in `.env`
- Use Mailtrap for development testing
- Check Laravel logs: `storage/logs/laravel.log`
- Test mail: `php artisan tinker` → `Mail::raw('Test', function($msg) { $msg->to('test@example.com'); })`

#### 4. Authorization errors
- Ensure TodoPolicy is registered in `AuthServiceProvider`
- Check user_id matches authenticated user
- Verify middleware is applied: `php artisan route:list`

#### 5. Foreign key constraint errors
- Ensure user exists before creating todos
- Check user_id is set correctly
- Run `php artisan migrate:fresh` if needed (WARNING: deletes all data)

## Technologies Used

- **Backend**: Laravel 10.x/11.x
- **Frontend**: Blade Templates, Bootstrap 5 / Tailwind CSS
- **Database**: MySQL/MariaDB/PostgreSQL/SQLite
- **Authentication**: Laravel Breeze / Custom Auth
- **Email**: Laravel Mail
- **PHP**: 8.1+
- **Icons**: Font Awesome 6 / Heroicons

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request, especially for the pending features listed above.

### Priority Contributions Needed
1. Mobile responsive improvements for all pages
2. Terms of Service and Privacy Policy pages
3. Settings page with avatar upload functionality
4. Google OAuth integration (Laravel Socialite)
5. Advanced filtering (by priority, due date, status)
6. Todo categories/tags system
7. Todo sharing between users

### How to Contribute
1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add amazing feature'`
4. Push to the branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues, questions, or suggestions, please open an issue in the repository.

---

**Version**: 1.0.0  
**Status**: Beta (Core features complete, enhancements pending)  
**Last Updated**: December 2025
