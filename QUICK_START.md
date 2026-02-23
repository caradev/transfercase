# Quick Start Guide - Home Image Management with Roles

## ✅ What's Been Implemented

### 2 Roles Created:
1. **Admin** - Can manage home page images
2. **User** - Cannot manage images, sees blank dashboard

### Components:
- **DisplayImage** - Shows image on home page (visible to all)
- **ManageHomeImage** - Dashboard component (admin only)

## 🚀 Quick Setup (Run These Commands)

```bash
# 1. Run migrations (if not done)
php artisan migrate

# 2. Create storage link (if not done)
php artisan storage:link

# 3. Seed roles and permissions (already done ✓)
php artisan db:seed --class=RolePermissionSeeder

# 4. Assign roles to users (already done ✓)
php artisan db:seed --class=AssignUserRolesSeeder
```

## 👤 User Management

### Assign Roles to Users

```bash
# Make someone an admin
php artisan user:assign-role user@example.com admin

# Make someone a regular user
php artisan user:assign-role user@example.com user
```

## 📱 How It Works

### For Admin Users:
1. Login to the application
2. Go to Dashboard
3. See full image management interface:
   - Upload new image
   - Preview before upload
   - Delete current image
4. Changes reflect immediately on home page

### For Regular Users:
1. Login to the application
2. Go to Dashboard
3. See welcome message: "Welcome to your dashboard"
4. Cannot upload or manage images
5. Can still view images on the home page

## 🎯 Current Setup

✅ **test@example.com** - Already assigned **admin** role
- This user can manage home page images

## 📝 Test Your Setup

### Test as Admin:
1. Login with: `test@example.com`
2. Visit `/dashboard`
3. You should see the image management interface

### Test as Regular User:
1. Create a new user account
2. Run: `php artisan user:assign-role newuser@example.com user`
3. Login with new user
4. Visit `/dashboard`
5. You should see a blank welcome message

## 📂 Files Created/Modified

### New Files:
- ✅ `app/Livewire/DisplayImage.php`
- ✅ `app/Livewire/ManageHomeImage.php`
- ✅ `resources/views/livewire/display-image.blade.php`
- ✅ `resources/views/livewire/manage-home-image.blade.php`
- ✅ `database/migrations/2026_02_23_165000_add_home_image_to_users_table.php`
- ✅ `database/seeders/RolePermissionSeeder.php`
- ✅ `database/seeders/AssignUserRolesSeeder.php`
- ✅ `app/Console/Commands/AssignRoleCommand.php`

### Modified Files:
- ✅ `app/Models/User.php` (added HasRoles trait)
- ✅ `resources/views/home.blade.php` (added DisplayImage component)
- ✅ `resources/views/dashboard.blade.php` (added ManageHomeImage component)
- ✅ `database/seeders/DatabaseSeeder.php` (added role seeders)

## 🔐 Permission System

| Permission | Admin | User |
|------------|-------|------|
| View home page image | ✓ | ✓ |
| Upload/Delete home image | ✓ | ✗ |
| Access dashboard | ✓ | ✓ |
| Manage home image | ✓ | ✗ |

## 📚 Documentation Files

- `HOME_IMAGE_SETUP.md` - Original image management setup
- `PERMISSIONS_SETUP.md` - Detailed permissions documentation
- `QUICK_START.md` - This file

## 🎉 You're All Set!

Everything is configured and ready to use. The first user (test@example.com) is already an admin and can manage images.

