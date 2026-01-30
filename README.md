                                                                                                     Event Registration – Custom Drupal 10 Module

A custom Drupal 10 module that allows administrators to create events and users to register for them via a dynamic registration form. The module stores registrations in custom database tables, prevents duplicates, and sends email notifications using Drupal Mail API.

✅ Features Overview

Admin can create and manage events

Users can register for events using a custom form

Dynamic dropdowns using AJAX (Category → Date → Event)

Prevents duplicate registrations

Stores all data in custom database tables

Sends email notifications to users and admins

Admin listing page with filters and CSV export

Fully compliant with Drupal 10 standards (no contrib modules)

📦 Module Structure
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
    │
    └── src/
        ├── Form/
        │   ├── EventConfigForm.php
        │   ├── EventAddForm.php
        │   ├── EventRegisterForm.php
        │   └── EventEmailConfigForm.php
        │
        └── Controller/
            ├── EventListController.php
            ├── RegistrationListController.php
            └── RegistrationExportController.php


⚙️ Installation Steps

Clone the repository

Place the event_registration folder inside:

web/modules/custom/


Import database tables using the provided SQL file:

event_registration_tables.sql


(via phpMyAdmin or MySQL CLI)

Enable the module:

Admin → Extend → Event Registration


Clear cache:

Admin → Configuration → Performance → Clear cache

🔗 Important URLs
Admin Pages

Add Event

/admin/config/event-registration


Event Listing

/admin/events


Event Registrations (Admin List)

/admin/events/registrations


CSV Export

/admin/events/registrations/export


Email Configuration

/admin/config/event-registration/email

User Page

Event Registration Form

/events/register

🧾 Database Tables
1️⃣ Event Configuration Table

event_registration_event

Column	Description
id	Primary key
event_name	Event name
category	Event category
event_date	Event date
reg_start	Registration start date
reg_end	Registration end date
created	Timestamp
2️⃣ Event Registration Table

event_registration_signup

Column	Description
id	Primary key
event_id	Foreign key to event
full_name	User name
email	User email
college	College name
department	Department
created	Timestamp
🧠 Form Logic
Event Configuration (Admin)

Creates events with:

Name

Category

Event Date

Registration start & end date

Stored directly in database

Event Registration (User)

Visible only during registration window

AJAX flow:

Category → Event Date → Event Name

✅ Validation Rules

Email format validation

Prevents duplicate registration:

Email + Event ID


No special characters allowed in:

Full Name

College

Department

User-friendly error messages displayed

📧 Email Notifications (Verified)

Email notifications are implemented using Drupal Mail API and verified via hook_mail().

Emails Sent:

User Confirmation Email

Name

Event Name

Event Date

Category

Admin Notification Email

Sent only if enabled

Admin email configurable via UI

Configuration:
/admin/config/event-registration/email

Implementation:

hook_mail() implemented in:

event_registration.module


Emails triggered after successful registration submission

🔐 Permissions

Custom permission added:

View event registrations


Required for accessing:

/admin/events/registrations


Assign via:

Admin → People → Permissions

📊 Admin Registration Listing

Filter by:

Event Date

Event Name

Displays:

Name

Email

Event

Event Date

College

Department

Submission date

Shows total participant count

CSV export available

📁 Screenshots (Optional)

<img width="1365" height="673" alt="Screenshot 2026-01-29 224110" src="https://github.com/user-attachments/assets/e15cd2f3-75b7-47f4-965f-40cf0ab2c84a" />
<img width="1365" height="663" alt="Screenshot 2026-01-29 221547" src="https://github.com/user-attachments/assets/85de4f46-e1e6-4bdd-9bf0-a74efd2a549a" />
<img width="884" height="669" alt="Screenshot 2026-01-29 221513" src="https://github.com/user-attachments/assets/c3ce77bc-2df8-4f04-923d-0f78f5a0fa4f" />
<img width="1365" height="669" alt="Screenshot 2026-01-29 221409" src="https://github.com/user-attachments/assets/5d26909b-32b8-4a96-895c-77d3e4657d86" />
<img width="1365" height="681" alt="Screenshot 2026-01-29 221333" src="https://github.com/user-attachments/assets/59ec0851-d51d-486b-9e81-b2128cf71c66" />
<img width="1365" height="682" alt="Screenshot 2026-01-29 221255" src="https://github.com/user-attachments/assets/a32c4046-4dec-4940-b57c-ee26d7f825f2" />


/screenshots/
├── event-config-form.png
├── event-list.png
├── registration-form.png
├── registration-list.png
├── email-config.png


Then reference in README like:

![Event Configuration](screenshots/event-config-form.png)

🧪 Technical Compliance

✔ Drupal 10.x
✔ No contrib modules
✔ PSR-4 autoloading
✔ Dependency Injection used
✔ Clean routing and permissions
✔ Config API used
✔ Database schema provided
✔ SQL dump included# Event-Registration-Drupal
