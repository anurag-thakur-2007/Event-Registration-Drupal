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

