# Event Registration Module (Drupal 10)

A custom Drupal 10 module that allows administrators to configure events and users to register for them via a dynamic registration form.  
The module stores registrations in custom database tables and sends email notifications using Drupal Mail API.

---

## 🚀 Features Overview

- Custom **Event Configuration** page for admins  
- Dynamic **Event Registration Form** with AJAX  
- Strong validation (duplicate prevention, input validation)  
- Custom database tables (no nodes, no contrib modules)  
- Email notifications using **Drupal Mail API + hook_mail()**  
- Admin listing of registrations with filters  
- CSV export of registrations  
- Custom permissions for admin access  

---

## 🛠️ Technical Stack

- **Drupal Version:** 10.x  
- **PHP Version:** 8.x  
- **Database:** MySQL  
- **No contributed modules used**  
- **PSR-4 compliant**  
- **Drupal Coding Standards followed**

---

## 📁 Module Structure

```text
event-registration-drupal/
│
├── composer.json
├── composer.lock
├── README.md
├── event_registration_tables.sql
│
└── event_registration/
    ├── event_registration.info.yml
    ├── event_registration.module
    ├── event_registration.install
    ├── event_registration.permissions.yml
    ├── event_registration.routing.yml
    ├── event_registration.links.menu.yml
    └── src/
        ├── Form/
        │   ├── EventConfigForm.php
        │   ├── EventAddForm.php
        │   ├── EventRegisterForm.php
        │   └── EventEmailConfigForm.php
        └── Controller/
            ├── EventListController.php
            ├── RegistrationListController.php
            └── RegistrationExportController.php
```

---

## ⚙️ Installation Steps

### Clone the repository
```bash
git clone <repository-url>
```

### Place the module inside
```
web/modules/custom/event_registration
```

### Import database tables

Open phpMyAdmin and import:

```
event_registration_tables.sql
```

### Enable the module
```bash
drush en event_registration
```

### Clear cache
```bash
drush cr
```

---

## 🔗 Important URLs

### Admin Pages

| Feature | URL |
|--------|-----|
| Event Configuration (Add Events) | `/admin/config/event-registration` |
| Event List (Admin View) | `/admin/events` |
| Email Configuration | `/admin/config/event-registration/email` |
| Registration List (Admin) | `/admin/events/registrations` |
| Export Registrations (CSV) | `/admin/events/registrations/export` |

### User Page

| Feature | URL |
|--------|-----|
| Event Registration Form | `/events/register` |

---

## 🧩 Event Configuration (Admin)

Admins can configure events with:

- Event Name  
- Category *(Online Workshop, Hackathon, Conference, One-day Workshop)*  
- Event Date  
- Registration Start Date  
- Registration End Date  

Events are stored in a custom table:

```
event_registration_event
```

---

## 📝 Event Registration Form (User)

Available only between registration start and end dates.

### Fields

- Full Name  
- Email Address  
- College Name  
- Department  
- Event Category *(AJAX)*  
- Event Date *(AJAX)*  
- Event Name *(AJAX)*  

### AJAX Behavior

- Event Dates load based on selected category  
- Event Names load based on selected category + date  

---

## ✅ Validation Rules

Prevents duplicate registration using:

```
Email + Event
```

Validations include:

- Proper email format  
- No special characters in text fields  
- User-friendly error messages  

---

## 🗄️ Database Tables

### 1️⃣ event_registration_event

- id  
- event_name  
- category  
- event_date  
- reg_start  
- reg_end  
- created  

### 2️⃣ event_registration_signup

- id  
- event_id (foreign key)  
- full_name  
- email  
- college  
- department  
- created  

---

## 📧 Email Notifications

Email functionality is implemented using Drupal Mail API and verified via `hook_mail()`.

### Emails Sent

- User confirmation email  
- Admin notification email (optional)

### Config Stored In

```
event_registration.settings
```

### hook_mail() Implementation

```php
function event_registration_mail($key, &$message, $params) {
  $message['from'] = \Drupal::config('system.site')->get('mail');
  $message['subject'] = $params['subject'];
  $message['body'][] = $params['message'];
}
```

✔ Email logic is verified  
✔ No hard-coded values  
✔ Fully configurable from admin UI  

---

## 📊 Admin Registration Listing

Accessible only to users with permission:

```
View event registrations
```

Features:

- Filter by Event Date  
- Filter by Event Name  
- Shows total participant count  
- Export filtered results as CSV  

---

## 🔐 Permissions

Assign permission via:

**Admin → People → Permissions**

Permission name:

```
View event registrations
```

---

## 🧪 Screenshots (Optional)

Add screenshots inside an `/images` folder and reference like:

```md
![Event Configuration](images/event-config.png)
![Registration Form](images/event-register.png)
![Admin List](images/admin-list.png)
```
