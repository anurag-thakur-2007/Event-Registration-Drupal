# Event Registration Module (Drupal 10)

<<<<<<< HEAD
A custom Drupal 10 module that allows administrators to configure events and users to register for them via a dynamic registration form.
=======
A custom Drupal 10 module that allows administrators to configure events and users to register for them via a dynamic registration form.  
>>>>>>> d2be512 (updated readme)
The module stores registrations in custom database tables and sends email notifications using Drupal Mail API.

---

## 🚀 Features Overview

<<<<<<< HEAD
- Custom Event Configuration page for admins
- Dynamic Event Registration Form with AJAX
- Strong validation (duplicate prevention, input validation)
- Custom database tables (no nodes, no contrib modules)
- Email notifications using Drupal Mail API + hook_mail()
=======
- Custom **Event Configuration** page for admins
- Dynamic **Event Registration Form** with AJAX
- Strong validation (duplicate prevention, input validation)
- Custom database tables (no nodes, no contrib modules)
- Email notifications using **Drupal Mail API + hook_mail()**
>>>>>>> d2be512 (updated readme)
- Admin listing of registrations with filters
- CSV export of registrations
- Custom permissions for admin access

---

## 🛠️ Technical Stack

<<<<<<< HEAD
- Drupal Version: 10.x
- PHP Version: 8.x
- Database: MySQL
- No contributed modules used
- PSR-4 compliant
- Drupal Coding Standards followed

---
=======
- **Drupal Version:** 10.x  
- **PHP Version:** 8.x  
- **Database:** MySQL  
- **No contributed modules used**
- **PSR-4 compliant**
- **Drupal Coding Standards followed**

---

>>>>>>> d2be512 (updated readme)
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
<<<<<<< HEAD
```



---

# ⚙️ Installation Steps

### Clone the repository
git clone <repository-url>

### Place the module inside
web/modules/custom/event_registration

### Import database tables
1. Open phpMyAdmin
2. Import file: event_registration_tables.sql

### Enable the module
drush en event_registration

### Clear cache
drush cr

---

# 🔗 Important URLs

## Admin Pages

| Feature | URL |
|--------|-----|
| Event Configuration (Add Events) | /admin/config/event-registration |
| Event List (Admin View) | /admin/events |
| Email Configuration | /admin/config/event-registration/email |
| Registration List (Admin) | /admin/events/registrations |
| Export Registrations (CSV) | /admin/events/registrations/export |

## User Page

| Feature | URL |
|--------|-----|
| Event Registration Form | /events/register |

---

# 🧩 Event Configuration (Admin)

Admins can configure events with:

- Event Name
- Category (Online Workshop, Hackathon, Conference, One-day Workshop)
- Event Date
- Registration Start Date
- Registration End Date
=======


⚙️ Installation Steps


Clone the repository:

git clone <repository-url>


Place the module inside:

web/modules/custom/event_registration


Import database tables:

Open phpMyAdmin

Import event_registration_tables.sql

Enable the module:

drush en event_registration


Clear cache:

drush cr

🔗 Important URLs


Admin Pages

Event Configuration (Add Events)
/admin/config/event-registration

Event List (Admin View)
/admin/events

Email Configuration
/admin/config/event-registration/email

Registration List (Admin)
/admin/events/registrations

Export Registrations (CSV)
/admin/events/registrations/export

User Page

Event Registration Form
/events/register


🧩 Event Configuration (Admin)


Admins can configure events with:

Event Name

Category (Online Workshop, Hackathon, Conference, One-day Workshop)

Event Date

Registration Start Date

Registration End Date
>>>>>>> d2be512 (updated readme)

Events are stored in a custom table:

event_registration_event

<<<<<<< HEAD
---

# 📝 Event Registration Form (User)

Available only between registration start and end dates.

### Fields

- Full Name
- Email Address
- College Name
- Department
- Event Category (AJAX)
- Event Date (AJAX)
- Event Name (AJAX)

### AJAX Behavior

- Event Dates load based on selected category
- Event Names load based on selected category + date

---

# ✅ Validation Rules
=======

#📝 Event Registration Form (User)


Available only between registration start and end dates.

Fields:

Full Name

Email Address

College Name

Department

Event Category (AJAX)

Event Date (AJAX)

Event Name (AJAX)

AJAX Behavior:

Event Dates load based on selected category

Event Names load based on selected category + date


✅ Validation Rules

>>>>>>> d2be512 (updated readme)

Prevents duplicate registration using:

Email + Event

<<<<<<< HEAD
### Validations

- Proper email format
- No special characters in text fields
- User-friendly error messages

---

# 🗄️ Database Tables

## 1️⃣ event_registration_event

Stores event configuration:

- id
- event_name
- category
- event_date
- reg_start
- reg_end
- created

## 2️⃣ event_registration_signup

Stores user registrations:

- id
- event_id (foreign key)
- full_name
- email
- college
- department
- created

---

# 📧 Email Notifications

Email functionality is implemented using Drupal Mail API and verified via hook_mail().

### Emails Sent

- User confirmation email
- Admin notification email (optional)

### Configuration

Admin can configure:

- Admin email address
- Enable/disable admin notifications
=======

Validates:

Email format

No special characters in text fields

Displays user-friendly error messages


🗄️ Database Tables
1️⃣ event_registration_event

Stores event configuration:

id

event_name

category

event_date

reg_start

reg_end

created

2️⃣ event_registration_signup

Stores user registrations:

id

event_id (foreign key)

full_name

email

college

department

created


📧 Email Notifications


Email functionality is implemented using Drupal Mail API and verified via hook_mail().

Emails Sent:

User confirmation email

Admin notification email (optional)

Configuration:

Admin can configure:

Admin email address

Enable/disable admin notifications
>>>>>>> d2be512 (updated readme)

Config stored using Drupal Config API:

event_registration.settings

<<<<<<< HEAD
### hook_mail() Implementation

=======
hook_mail Implementation:
>>>>>>> d2be512 (updated readme)
function event_registration_mail($key, &$message, $params) {
  $message['from'] = \Drupal::config('system.site')->get('mail');
  $message['subject'] = $params['subject'];
  $message['body'][] = $params['message'];
}

<<<<<<< HEAD
=======

>>>>>>> d2be512 (updated readme)
✔ Email logic is verified
✔ No hard-coded values
✔ Fully configurable from admin UI

<<<<<<< HEAD
---

# 📊 Admin Registration Listing
=======

📊 Admin Registration Listing

>>>>>>> d2be512 (updated readme)

Accessible only to users with permission:

View event registrations

<<<<<<< HEAD
### Features

- Filter by Event Date
- Filter by Event Name

### Displays

- Name
- Email
- Event Date
- College
- Department
- Submission Date

Additional features:

- Shows total participant count
- Export filtered results as CSV

---

# 🔐 Permissions
=======
Features:

Filter by Event Date

Filter by Event Name

Displays:

Name

Email

Event Date

College

Department

Submission Date

Shows total participant count

Export filtered results as CSV

🔐 Permissions
>>>>>>> d2be512 (updated readme)

Custom permission defined:

View event registrations

Assign via:

Admin → People → Permissions

<<<<<<< HEAD
---

# 🧪 Screenshots 
<img width="1365" height="673" alt="Screenshot 2026-01-29 224110" src="https://github.com/user-attachments/assets/13910441-5cf5-47a2-a5c6-662b3d12e3d4" />
<img width="1365" height="663" alt="Screenshot 2026-01-29 221547" src="https://github.com/user-attachments/assets/b6087b95-232b-47e7-b16c-b26fc73ca58d" />
<img width="884" height="669" alt="Screenshot 2026-01-29 221513" src="https://github.com/user-attachments/assets/11244d81-4146-4c92-a168-9605b0a64c6d" />
<img width="1365" height="669" alt="Screenshot 2026-01-29 221409" src="https://github.com/user-attachments/assets/cc48f13c-807b-420a-95a8-857f7b938778" />
<img width="1365" height="681" alt="Screenshot 2026-01-29 221333" src="https://github.com/user-attachments/assets/8ac73dd8-093f-4c18-9102-3df301292822" />
<img width="1365" height="682" alt="Screenshot 2026-01-29 221255" src="https://github.com/user-attachments/assets/ad417432-c927-4587-869b-96fc4cd38871" />



=======
🧪 Screenshots (Optional)
>>>>>>> d2be512 (updated readme)
