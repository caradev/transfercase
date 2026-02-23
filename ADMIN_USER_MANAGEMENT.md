# Admin User Management System

## Overview
A complete admin-only user management system that allows administrators to create, read, update, and delete users, as well as manage their roles.

## Features

### ✅ Full CRUD Operations
- **Create** - Add new users with name, email, password, and role
- **Read** - View all users in a paginated table with search and filtering
- **Update** - Edit user details including name, email, password (optional), and role
- **Delete** - Remove users (cannot delete yourself)

### ✅ Role Management
- Quick role switching via dropdown in the user table
- Role selection during user creation/editing
- Role-based filtering in the user list

### ✅ Search & Filter
- **Search** - Search by user name or email (live search with debounce)
- **Filter** - Filter users by role (admin/user)

### ✅ Security Features
- Admin-only access (protected by role middleware)
- Cannot delete your own account
- Password confirmation required
- Email uniqueness validation
- Optional password update (leave blank to keep current)

### ✅ User Experience
- Modal-based forms for create/edit
- Real-time search with debounce
- Success/error flash messages
- User avatars with initials
- "You" indicator for current user
- Confirmation before deletion
- Pagination for large user lists
- Mobile-responsive design
- Dark mode support

---

## Files Created

### 1. Component
- `app/Livewire/Admin/UserManagement.php`
  - Main Livewire component with all CRUD logic
  - Search, filter, and pagination functionality
  - Permission checks

### 2. View
- `resources/views/livewire/admin/user-management.blade.php`
  - User table with search/filter controls
  - Modal for create/edit forms
  - Responsive design with Tailwind CSS

### 3. Page
- `resources/views/admin/users.blade.php`
  - Admin user management page wrapper

### 4. Route
- Updated `routes/web.php`
  - Added `/admin/users` route with `role:admin` middleware

### 5. Navigation
- Updated `resources/views/layouts/app/sidebar.blade.php`
  - Added "Administration" section for admin users
  - "User Management" link visible only to admins

### 6. Middleware
- Updated `bootstrap/app.php`
  - Registered Spatie permission middleware aliases

---

## Access Control

### Route Protection
```php
Route::view('admin/users', 'admin.users')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.users');
```

### Component Protection
```php
public function mount()
{
    if (!auth()->user()->hasRole('admin')) {
        abort(403, 'Unauthorized access.');
    }
}
```

### Navigation
Only users with the `admin` role see the "Administration" menu section.

---

## Usage

### Accessing the Page

**As an Admin:**
1. Login to the application
2. Look for "Administration" section in the sidebar
3. Click "User Management"
4. You'll see the full user management interface

**As a Regular User:**
- The "Administration" section is not visible
- Direct access to `/admin/users` returns 403 Forbidden

### Creating a User

1. Click the **"+ Create User"** button (top right)
2. Fill in the form:
   - **Name** (required)
   - **Email** (required, must be unique)
   - **Role** (required - admin or user)
   - **Password** (required, min 8 characters)
   - **Confirm Password** (required)
3. Click **"Create"**
4. User is created and assigned the selected role

### Editing a User

1. Click **"Edit"** on any user row
2. Update the fields:
   - Name
   - Email
   - Role (dropdown)
   - Password (optional - leave blank to keep current)
3. Click **"Update"**

### Deleting a User

1. Click **"Delete"** on any user row (except yourself)
2. Confirm the deletion
3. User is permanently deleted

### Changing User Roles

**Quick Method (from table):**
- Use the role dropdown in the user row
- Select new role
- Role is updated immediately

**Full Edit Method:**
- Click "Edit" on the user
- Change the role in the modal
- Click "Update"

### Searching Users

- Type in the search box at the top
- Searches by name or email
- Results update automatically (300ms debounce)

### Filtering by Role

- Use the "Role" dropdown
- Select "Admin" or "User" to filter
- Select "All Roles" to show everyone

---

## User Table Columns

| Column | Description |
|--------|-------------|
| **User** | Avatar with initials and name. Shows "(You)" for current user |
| **Email** | User's email address |
| **Role** | Dropdown to quickly change role |
| **Created** | Account creation date |
| **Actions** | Edit and Delete buttons |

---

## Validation Rules

### Creating a User
- **Name**: Required, string, max 255 characters
- **Email**: Required, valid email, unique
- **Password**: Required, min 8 characters, must match confirmation
- **Role**: Required, must exist in roles table

### Updating a User
- **Name**: Required, string, max 255 characters
- **Email**: Required, valid email, unique (except for current user)
- **Password**: Optional (if provided: min 8 characters, must match confirmation)
- **Role**: Required, must exist in roles table

---

## UI Components

### Search Bar
```
┌────────────────────────────────────────────┐
│ Search by name or email...                │
└────────────────────────────────────────────┘
```

### Filter Dropdown
```
┌─────────────┐
│ All Roles  ▼│
├─────────────┤
│ All Roles   │
│ Admin       │
│ User        │
└─────────────┘
```

### User Table
```
┌──────────────────────────────────────────────────────────────────┐
│ User              │ Email           │ Role  │ Created  │ Actions │
├──────────────────────────────────────────────────────────────────┤
│ [SA] Super Admin  │ test@example... │ Admin │ Feb 23.. │ Edit Del│
│ (You)             │                 │       │          │         │
├──────────────────────────────────────────────────────────────────┤
│ [JD] John Doe     │ john@example... │ User  │ Feb 23.. │ Edit Del│
└──────────────────────────────────────────────────────────────────┘
```

### Create/Edit Modal
```
┌─────────────────────────────────────┐
│ Create New User              [X]    │
├─────────────────────────────────────┤
│ Name *                              │
│ ┌─────────────────────────────────┐ │
│ │                                 │ │
│ └─────────────────────────────────┘ │
│                                     │
│ Email *                             │
│ ┌─────────────────────────────────┐ │
│ │                                 │ │
│ └─────────────────────────────────┘ │
│                                     │
│ Role *                              │
│ ┌─────────────────────────────────┐ │
│ │ Select a role              ▼    │ │
│ └─────────────────────────────────┘ │
│                                     │
│ Password *                          │
│ ┌─────────────────────────────────┐ │
│ │ ••••••••                        │ │
│ └─────────────────────────────────┘ │
│                                     │
│ Confirm Password                    │
│ ┌─────────────────────────────────┐ │
│ │ ••••••••                        │ │
│ └─────────────────────────────────┘ │
│                                     │
│         [Cancel]  [Create]          │
└─────────────────────────────────────┘
```

---

## Permissions Required

| Action | Permission Required |
|--------|-------------------|
| Access page | `admin` role |
| View users | `admin` role |
| Create user | `admin` role |
| Edit user | `admin` role |
| Delete user | `admin` role |
| Change role | `admin` role |

---

## Error Handling

### Common Errors

1. **"You cannot delete your own account!"**
   - Attempting to delete yourself
   - Solution: Ask another admin to delete your account

2. **"Unauthorized access"**
   - Non-admin trying to access the page
   - Returns 403 Forbidden

3. **Email validation error**
   - Email already exists
   - Solution: Use a unique email

4. **Password confirmation mismatch**
   - Passwords don't match
   - Solution: Ensure both password fields match

---

## Testing

### Test as Admin
```bash
# Login with test@example.com (already an admin)
# Navigate to /admin/users
# You should see the user management interface
```

### Test as Regular User
```bash
# Create a new user
# Assign 'user' role: php artisan user:assign-role user@example.com user
# Login with that user
# Try to access /admin/users
# Should get 403 Forbidden
# "Administration" menu should not be visible
```

### Test CRUD Operations
1. **Create**: Add a new user with all required fields
2. **Read**: Search and filter the user list
3. **Update**: Edit the user's name and role
4. **Delete**: Remove the user (confirm deletion works)

---

## API/Methods

### Component Public Methods

```php
// Open create user modal
createUser()

// Open edit user modal
editUser($userId)

// Save user (create or update)
saveUser()

// Delete user
deleteUser($userId)

// Update user role (quick action)
updateUserRole($userId, $roleName)

// Close modal
closeModal()
```

### Component Properties

```php
public $showModal = false;        // Modal visibility
public $editMode = false;         // Create vs Edit mode
public $userId;                   // Current user ID being edited
public $name;                     // Form: name
public $email;                    // Form: email
public $password;                 // Form: password
public $password_confirmation;    // Form: password confirmation
public $selectedRole;             // Form: role selection
public $search = '';              // Search query
public $roleFilter = '';          // Role filter
```

---

## Navigation Structure

```
Sidebar (Admin Only)
├── Platform
│   └── Dashboard
└── Administration
    └── User Management  <-- NEW
```

---

## Route Details

| Method | URI | Name | Middleware |
|--------|-----|------|------------|
| GET | /admin/users | admin.users | auth, verified, role:admin |

---

## Future Enhancements (Optional)

- Bulk user operations (delete multiple)
- Export users to CSV/Excel
- Import users from CSV
- User activity logs
- Email verification status
- Account suspension/activation
- More granular permissions
- User profile pictures
- Last login timestamp
- Password reset functionality
- Bulk role assignment

---

## Summary

✅ **Complete CRUD system** for user management  
✅ **Admin-only access** with role-based security  
✅ **Search and filter** functionality  
✅ **Role management** with quick dropdown switcher  
✅ **Mobile responsive** design with dark mode  
✅ **Integrated navigation** in the admin sidebar  
✅ **Security features** preventing self-deletion and unauthorized access  

**The system is fully functional and ready to use!** 🎉

Access it at: `/admin/users` (admin login required)

