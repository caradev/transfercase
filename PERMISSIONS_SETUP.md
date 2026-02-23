# Spatie Laravel Permissions Setup

## Overview
This project now uses Spatie Laravel Permissions to manage user roles and access control for the home page image management feature.

## Roles Created

### 1. **Admin Role**
- Can manage (upload/delete) the home page image
- Has full access to the dashboard management interface
- Permission: `manage home image`

### 2. **User Role**
- Cannot manage the home page image
- Sees a blank/welcome message on the dashboard
- No special permissions

## What Was Implemented

### 1. Updated User Model
- Added `HasRoles` trait from Spatie Permissions
- File: `app/Models/User.php`

### 2. Created Seeders

#### RolePermissionSeeder
- Creates `admin` and `user` roles
- Creates `manage home image` permission
- Assigns permission to admin role
- File: `database/seeders/RolePermissionSeeder.php`

#### AssignUserRolesSeeder
- Assigns `admin` role to the first user in the database
- Assigns `user` role to all other users
- File: `database/seeders/AssignUserRolesSeeder.php`

### 3. Updated Components

#### ManageHomeImage Component
- Added permission checks to `uploadImage()` and `deleteImage()` methods
- Added `canManage` property to track user permissions
- File: `app/Livewire/ManageHomeImage.php`

#### manage-home-image.blade.php View
- Shows image management interface only to users with `manage home image` permission
- Displays a welcome message for regular users
- File: `resources/views/livewire/manage-home-image.blade.php`

## Setup Instructions

### Step 1: Run Migrations
```bash
php artisan migrate
```

### Step 2: Seed Roles and Permissions
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Step 3: Assign Roles to Existing Users
```bash
php artisan db:seed --class=AssignUserRolesSeeder
```

Or run all seeders at once:
```bash
php artisan db:seed
```

### Step 4: Create Storage Link (if not exists)
```bash
php artisan storage:link
```

## Managing Roles

### Quick Role Assignment (Artisan Command)
```bash
# Assign admin role to a user
php artisan user:assign-role user@example.com admin

# Assign user role to a user
php artisan user:assign-role user@example.com user
```

### Programmatic Role Assignment

#### Assign Admin Role to a User
```php
$user = User::find($userId);
$user->assignRole('admin');
```

### Assign User Role to a User
```php
$user = User::find($userId);
$user->assignRole('user');
```

### Check if User Has Permission
```php
if (auth()->user()->hasPermissionTo('manage home image')) {
    // User can manage images
}
```

### Check if User Has Role
```php
if (auth()->user()->hasRole('admin')) {
    // User is an admin
}
```

## Creating New Users with Roles

When registering new users, you can assign them a role:

```php
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password'),
]);

// Assign default user role
$user->assignRole('user');

// Or assign admin role
$user->assignRole('admin');
```

## Behavior

### Admin Users
- Dashboard shows the full image management interface
- Can upload new images
- Can preview images before uploading
- Can delete the current image
- Changes are immediately reflected on the home page

### Regular Users
- Dashboard shows a welcome message: "Welcome to your dashboard"
- Message: "You don't have any management permissions yet."
- Cannot upload or delete images
- Still see the image on the home page (read-only)

## Permissions List

| Permission | Description | Roles |
|------------|-------------|-------|
| `manage home image` | Allows uploading and deleting the home page image | admin |

## Database Tables

Spatie Permissions creates the following tables:
- `roles` - Stores role definitions
- `permissions` - Stores permission definitions
- `model_has_roles` - Links users to roles
- `model_has_permissions` - Direct user permissions (not currently used)
- `role_has_permissions` - Links roles to permissions

## Testing

### Test as Admin
1. Log in with the first user (automatically assigned admin role)
2. Navigate to dashboard
3. You should see the full image management interface

### Test as Regular User
1. Create a new user
2. Assign them the 'user' role
3. Log in with that user
4. Navigate to dashboard
5. You should see a blank welcome message

## Artisan Commands

### List all roles
```bash
php artisan tinker
>>> \Spatie\Permission\Models\Role::all();
```

### List all permissions
```bash
php artisan tinker
>>> \Spatie\Permission\Models\Permission::all();
```

### Clear permission cache
```bash
php artisan permission:cache-reset
```

## Future Enhancements

You can easily add more permissions and roles:

```php
// Create a new permission
Permission::create(['name' => 'edit posts']);

// Create a new role
$editorRole = Role::create(['name' => 'editor']);

// Assign permission to role
$editorRole->givePermissionTo('edit posts');

// Assign role to user
$user->assignRole('editor');
```

