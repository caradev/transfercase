# Contact Form System - Complete Documentation

## Overview
A complete contact form system that captures inquiries, sends emails, and provides admin management capabilities.

## Features Implemented

### ✅ Public Contact Form
- **Name** - Required field
- **Email** - Required, validated
- **Phone** - Optional field
- **Subject** - Optional field
- **Message** - Required, minimum 10 characters
- **Real-time validation** with error messages
- **Success/error flash messages**
- **Loading states** during submission
- **Responsive design** with dark mode support

### ✅ Email Functionality
- **Automatic email** sent to `info@cara.dev`
- **Professional HTML email template**
- **Reply-to header** set to sender's email
- **Subject line** includes inquiry subject
- **Email includes** all form data and timestamp
- **Queued sending** (configurable)

### ✅ Database Storage
- All inquiries saved to `contact_inquiries` table
- Fields: name, email, phone, subject, message, is_read, timestamps
- Soft validation for data integrity
- Timestamps for tracking

### ✅ Admin Management
- **View all inquiries** in paginated table
- **Search** by name, email, subject, or message
- **Filter** by read/unread status
- **View details** in modal popup
- **Mark as read/unread**
- **Delete inquiries** with confirmation
- **Unread count badge** in header
- **Responsive table** with mobile support
- **Auto-mark as read** when viewing

---

## Files Created

### Models & Migrations
- `app/Models/ContactInquiry.php` - Eloquent model
- `database/migrations/2026_02_23_185542_create_contact_inquiries_table.php` - Table schema

### Mail
- `app/Mail/ContactInquiryMail.php` - Mailable class
- `resources/views/emails/contact-inquiry.blade.php` - Email template

### Livewire Components
- `app/Livewire/ContactForm.php` - Public contact form
- `app/Livewire/Admin/ContactInquiries.php` - Admin management
- `resources/views/livewire/contact-form.blade.php` - Form view
- `resources/views/livewire/admin/contact-inquiries.blade.php` - Admin view

### Pages & Routes
- `resources/views/admin/contact-inquiries.blade.php` - Admin page
- Route: `/admin/contact-inquiries` (admin only)

### Updated Files
- `routes/web.php` - Added admin route
- `resources/views/layouts/app/sidebar.blade.php` - Added navigation link
- `resources/views/home.blade.php` - Integrated contact form

---

## Database Schema

```sql
CREATE TABLE contact_inquiries (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    subject VARCHAR(255) NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## Usage

### Public Contact Form

**Location:** Home page, `#contact` section
**URL:** `/#contact`

Users fill out the form with:
1. Name (required)
2. Email (required)
3. Phone (optional)
4. Subject (optional)
5. Message (required, min 10 characters)

**On Submit:**
- Form validates all fields
- Creates database record
- Sends email to info@cara.dev
- Shows success message
- Resets form

### Admin Management

**Location:** Admin dashboard
**URL:** `/admin/contact-inquiries`
**Access:** Admin role required

**Features:**
- **Table View** - See all inquiries with status
- **Search** - Find inquiries by any field
- **Filter** - Show all, read, or unread only
- **View Details** - Click "View" to see full inquiry
- **Mark Read/Unread** - Toggle status
- **Delete** - Remove inquiries permanently
- **Pagination** - 10 inquiries per page

---

## Admin Interface

### Navigation
```
Administration
├── User Management
└── Contact Inquiries  ← NEW
```

### Inquiries Table Columns
| Column | Description |
|--------|-------------|
| **Status** | Badge showing "New" (orange) or "Read" (gray) |
| **Name** | Contact name and phone (if provided) |
| **Email** | Contact email address |
| **Subject** | Inquiry subject (truncated to 30 chars) |
| **Date** | Date and time received |
| **Actions** | View, Toggle Read, Delete buttons |

### Inquiry Details Modal
- Full name with phone and email (clickable)
- Complete subject
- Full message (preserves line breaks)
- Timestamp with relative time
- Actions: Delete, Mark Read/Unread, Close

---

## Email Configuration

### Current Settings (from .env)
```
MAIL_MAILER=mailpit
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
```

### For Production
Update `.env` to use a real mail service:

```env
# Using SMTP (e.g., Gmail, SendGrid)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@transfercase.com
MAIL_FROM_NAME="${APP_NAME}"
```

Or use a service like:
- **Mailgun** - Recommended for transactional emails
- **SendGrid** - Good for high volume
- **Amazon SES** - Cost-effective
- **Postmark** - Excellent deliverability

### Queue Configuration (Optional)

For better performance, queue emails:

```env
QUEUE_CONNECTION=database
```

Then run the queue worker:
```bash
php artisan queue:work
```

---

## Validation Rules

### Contact Form
- **Name**: Required, string, max 255 characters
- **Email**: Required, valid email format, max 255 characters
- **Phone**: Optional, string, max 20 characters
- **Subject**: Optional, string, max 255 characters
- **Message**: Required, string, minimum 10 characters

---

## Security Features

### Admin Access Control
- Route protected with `role:admin` middleware
- Component-level permission check
- 403 error for non-admins

### Form Security
- CSRF protection (Laravel default)
- Input validation and sanitization
- XSS protection (Blade escaping)
- SQL injection protection (Eloquent)

### Email Security
- Reply-to header for direct responses
- No sensitive data in subject line
- Professional HTML formatting

---

## Testing

### Test Contact Form Submission
1. Navigate to `/#contact`
2. Fill out all fields
3. Click "Send message"
4. Verify success message appears
5. Check email at info@cara.dev (or Mailpit)
6. Verify database record created

### Test Admin View
```bash
# Login as admin
# Navigate to /admin/contact-inquiries
```

**Expected:**
- ✅ See all submitted inquiries
- ✅ New inquiries show orange "New" badge
- ✅ Unread count badge in header
- ✅ Search and filter work
- ✅ Can view details
- ✅ Can mark as read/unread
- ✅ Can delete inquiries

### Test Email with Mailpit
```bash
# Access Mailpit dashboard
http://localhost:8025

# Submit form
# Check Mailpit inbox for email
```

**Email Should Include:**
- Professional header with branding
- Sender name and contact info (clickable links)
- Subject (if provided)
- Full message
- Timestamp
- Reply-to functionality

---

## API Reference

### ContactForm Component

**Public Properties:**
```php
public $name = '';
public $email = '';
public $phone = '';
public $subject = '';
public $message = '';
```

**Methods:**
```php
submit() // Validate and submit form
```

**Validation:**
```php
protected $rules = [
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'nullable|string|max:20',
    'subject' => 'nullable|string|max:255',
    'message' => 'required|string|min:10',
];
```

### ContactInquiries Component

**Public Properties:**
```php
public $search = '';
public $filterRead = '';
public $showModal = false;
public $selectedInquiry;
```

**Methods:**
```php
viewInquiry($id)         // View inquiry details
closeModal()             // Close detail modal
toggleRead($id)          // Toggle read status
deleteInquiry($id)       // Delete inquiry
```

### ContactInquiry Model

**Fillable Fields:**
```php
protected $fillable = [
    'name',
    'email',
    'phone',
    'subject',
    'message',
    'is_read',
];
```

**Methods:**
```php
markAsRead()    // Mark inquiry as read
markAsUnread()  // Mark inquiry as unread
```

**Casts:**
```php
protected $casts = [
    'is_read' => 'boolean',
    'created_at' => 'datetime',
];
```

---

## Troubleshooting

### Emails Not Sending

**Check mail configuration:**
```bash
php artisan config:clear
php artisan config:cache
```

**Test mail connection:**
```bash
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('info@cara.dev')->subject('Test'); });
```

**Check logs:**
```bash
tail -f storage/logs/laravel.log
```

### Form Validation Errors

**Clear view cache:**
```bash
php artisan view:clear
```

**Check for JavaScript errors in browser console**

### Admin Page 403 Error

**Verify user has admin role:**
```bash
php artisan tinker
>>> User::where('email', 'test@example.com')->first()->roles->pluck('name');
```

**Assign admin role if needed:**
```bash
php artisan user:assign-role test@example.com admin
```

---

## Customization

### Change Email Recipient

Edit `app/Livewire/ContactForm.php`:
```php
Mail::to('your-email@example.com')->send(new ContactInquiryMail($inquiry));
```

### Add CC or BCC

```php
Mail::to('info@cara.dev')
    ->cc('manager@cara.dev')
    ->bcc('archive@cara.dev')
    ->send(new ContactInquiryMail($inquiry));
```

### Customize Email Template

Edit `resources/views/emails/contact-inquiry.blade.php`

### Change Form Fields

1. Update migration
2. Update model's `$fillable`
3. Update form view
4. Update component properties and rules
5. Update email template

### Add Auto-Reply Email

Create new Mailable:
```bash
php artisan make:mail ContactAutoReplyMail
```

In ContactForm.php:
```php
// Send to admin
Mail::to('info@cara.dev')->send(new ContactInquiryMail($inquiry));

// Send auto-reply to customer
Mail::to($this->email)->send(new ContactAutoReplyMail($inquiry));
```

---

## Performance Optimization

### Queue Emails

Update `.env`:
```env
QUEUE_CONNECTION=database
```

Update `ContactInquiryMail.php`:
```php
class ContactInquiryMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    // ...
}
```

Run queue worker:
```bash
php artisan queue:work
```

### Database Indexing

Add indexes for better search performance:
```php
Schema::table('contact_inquiries', function (Blueprint $table) {
    $table->index('email');
    $table->index('is_read');
    $table->index('created_at');
});
```

---

## Future Enhancements

### Suggested Features
- [ ] Auto-reply emails to customers
- [ ] Assign inquiries to team members
- [ ] Add notes/comments to inquiries
- [ ] Export inquiries to CSV
- [ ] Email templates for responses
- [ ] Categories/tags for inquiries
- [ ] Priority levels
- [ ] Response templates
- [ ] Email notifications for new inquiries
- [ ] Statistics dashboard
- [ ] Archive old inquiries
- [ ] Reply directly from admin panel

---

## Summary

✅ **Contact form** on home page  
✅ **Email** sent to info@cara.dev  
✅ **Database storage** of all inquiries  
✅ **Admin management** page  
✅ **Search and filter** functionality  
✅ **Read/unread tracking**  
✅ **Delete inquiries**  
✅ **Professional email template**  
✅ **Mobile responsive**  
✅ **Dark mode support**  

**Everything is ready to use!** 🎉

**Public Form:** `/#contact` on home page  
**Admin Panel:** `/admin/contact-inquiries` (admin login required)

