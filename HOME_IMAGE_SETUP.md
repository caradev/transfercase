# Home Image Livewire Component Setup

## Created Components

### 1. DisplayImage Component (`app/Livewire/DisplayImage.php`)
- Displays the home page image on the home.blade.php page
- Shows a fallback image if no custom image is set
- Listens to 'imageUpdated' event to refresh when image changes
- Located in: `/home/nickmont/PhpstormProjects/transfercase/app/Livewire/DisplayImage.php`

### 2. ManageHomeImage Component (`app/Livewire/ManageHomeImage.php`)
- Allows authenticated users to upload and manage the home page image
- Features:
  - Upload new images with validation (max 5MB, image files only)
  - Preview before uploading
  - Delete current image
  - Shows current image
- Located in: `/home/nickmont/PhpstormProjects/transfercase/app/Livewire/ManageHomeImage.php`

## Created Views

1. **display-image.blade.php** - Displays the image on home page
2. **manage-home-image.blade.php** - Management interface in dashboard

## Database Migration

Created migration: `database/migrations/2026_02_23_165000_add_home_image_to_users_table.php`
- Adds `home_image` column to users table (nullable string)
- Stores the file path to the uploaded image

## Setup Instructions

### 1. Run the Migration
```bash
php artisan migrate
```

### 2. Create Storage Link (if not exists)
```bash
php artisan storage:link
```

### 3. Updated Files
- **home.blade.php** - Now uses `<livewire:display-image />`
- **dashboard.blade.php** - Now uses `<livewire:manage-home-image />`
- **app/Models/User.php** - Added 'home_image' to fillable array

## Usage

1. **Home Page**: The image displays automatically using the `DisplayImage` component
2. **Dashboard**: Authenticated users can:
   - Upload a new image
   - Preview before uploading
   - Delete the current image
   - See the current image displayed

## File Storage

Images are stored in `storage/app/public/home-images/` and are accessible via the `/storage/` URL route.

## Events

The component uses Livewire's event system:
- `imageUpdated` - Dispatched when an image is uploaded or deleted to refresh the display component

