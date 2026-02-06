# 🎟️ Event Registration Module

<p align="center">
  <img src="https://img.shields.io/badge/Drupal-10.x-0678BE?style=for-the-badge&logo=drupal" />
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/Database-MySQL-orange?style=for-the-badge&logo=mysql" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" />
</p>

<p align="center">
  A production-ready <strong>Drupal 10 custom module</strong> for managing event registrations with dynamic forms, AJAX filtering, email notifications, and CSV exports — built entirely using Drupal Core APIs (no contrib modules).
</p>

---

## 📌 Executive Summary

The **Event Registration Module** is designed to demonstrate real-world Drupal backend engineering skills.  
It provides administrators with full control over event configuration and registration windows while offering users a seamless and validated registration experience.

The system leverages:

- Custom database schema
- AJAX-driven UI interactions
- Service-based email handling
- Clean architecture patterns
- Drupal coding standards & PSR-4 compliance

This project is structured for scalability and maintainability — ideal for enterprise-level implementations.

---

## 🚀 Key Features

### 🔧 Admin Capabilities

- Event configuration dashboard
- Controlled registration window (start/end date)
- Event categorization
- Registration listing with filters
- CSV export functionality
- Configurable email notifications
- Custom permission control

### 🧑‍💻 User Capabilities

- Dynamic event registration form
- AJAX-powered category → date → event selection
- Duplicate registration prevention
- Email confirmation on successful submission

---

## 🛠️ Technical Architecture

| Layer | Implementation |
|--------|---------------|
| Framework | Drupal 10 Core |
| Language | PHP 8.x |
| Database | MySQL |
| UI Handling | Drupal Form API + AJAX |
| Architecture | Repository + Service Pattern |
| Email | Drupal Mail API (`hook_mail`) |
| Dependency Injection | Fully implemented |
| Coding Standards | Drupal + PSR-4 |

---

## 📁 Project Structure

```text
Event-Registration-Drupal/
│
├── sql/
│   └── event_registration_tables.sql
│
├── web/
│   └── modules/
│       └── custom/
│           └── event_registration/
│               ├── event_registration.info.yml
│               ├── event_registration.install
│               ├── event_registration.permissions.yml
│               ├── event_registration.routing.yml
│               ├── event_registration.links.menu.yml
│               ├── event_registration.module
│               └── src/
│                   ├── Controller/
│                   ├── Form/
│                   ├── Repository/
│                   └── Service/
│
├── README.md
├── composer.json
└── composer.lock
```

---

# ⚙️ Installation Guide

## ✅ System Requirements

- PHP 8.1+
- Drupal 10.x
- MySQL / MariaDB
- Apache (XAMPP / LAMP / WAMP)
- Composer
- Drush (recommended)

---

## 🚀 Setup Instructions

### 1️⃣ Clone Repository

```bash
git clone https://github.com/anurag-thakur-2007/Event-Registration-Drupal.git
```

---

### 2️⃣ Place Module In Drupal Installation

Copy:

```
web/modules/custom/event_registration
```

Into your Drupal project:

```
your-drupal-site/web/modules/custom/
```

---

### 3️⃣ Import Database Tables

Using phpMyAdmin, import:

```
sql/event_registration_tables.sql
```

---

### 4️⃣ Enable Module

Using Drush:

```bash
drush en event_registration -y
drush cr
```

Or via Drupal Admin → Extend.

---

# 🔗 Application Endpoints

## 🔧 Administrative Interfaces

| Feature | URL |
|----------|------|
| Event Configuration | `/admin/config/event-registration` |
| Event Listing | `/admin/events` |
| Registration Listing | `/admin/events/registrations` |
| CSV Export | `/admin/events/registrations/export` |

## 🧑‍💻 Public Interface

| Feature | URL |
|----------|------|
| Event Registration Form | `/events/register` |

---

# 🗂️ Database Design

## 📁 event_registration_event

Stores event configuration metadata.

- id
- event_name
- category
- event_date
- reg_start
- reg_end
- created

## 📁 event_registration_signup

Stores participant registration records.

- id
- event_id (foreign key)
- full_name
- email
- college
- department
- created

✔ Referential integrity maintained  
✔ Optimized for filtering & reporting  

---

# 📝 Functional Breakdown

## 🛠️ Admin Event Management

- Create and manage multiple events
- Configure registration windows
- Categorize event types
- Manage participant data

---

## 🧾 User Registration Workflow

- Accessible only during active registration period
- AJAX-driven filtering
- Form validation & duplicate prevention
- Email confirmation dispatch

---

# ✅ Validation & Security

- Email format validation
- Special character restriction
- Duplicate submission prevention (Email + Event)
- Permission-based access control
- No direct DB exposure

---

# 📧 Email Notification System

Built using Drupal Mail API.

## User Confirmation

- Registration details
- Event summary

## Admin Notification (Optional)

- Triggered on new registration
- Configurable via admin UI

Configuration stored in:

```
event_registration.settings
```

---

# 📊 Admin Dashboard Capabilities

- Filter by Event Date
- Filter by Event Name
- Live participant count
- Dynamic table rendering
- CSV export for reporting

Permission required:

```
View event registrations
```

Assignable via:

Admin → People → Permissions

---

# 🧩 Engineering Highlights

- Clean separation of concerns
- Business logic abstracted from controllers
- Dependency injection throughout
- Repository pattern for database handling
- Service-based email dispatch
- No usage of `\Drupal::service()` in business logic
- Scalable and extensible architecture

---

# 🧪 Testing Guide

1. Enable module.
2. Create event via admin configuration.
3. Visit `/events/register`.
4. Submit registration.
5. Verify email delivery.
6. Review registration dashboard.
7. Export CSV report.

---

# 🎯 Ideal Use Cases

- University event registration
- Hackathons & workshops
- Corporate training programs
- Conference management
- Controlled-access event registration systems

---

# 📸 Application Screenshots

Below are the core interfaces of the Event Registration Module presented in workflow order.

---

## 1️⃣ Event Configuration Page (Admin)

Allows administrators to configure events, registration window, and category.

<img width="1365" height="682" alt="Screenshot 2026-01-29 221255" src="https://github.com/user-attachments/assets/87be2739-8551-448b-a735-39b81c3fec38" />


---

## 2️⃣ Events Listing Page (Admin)

Displays all configured events with event date and registration period.

<img width="1365" height="681" alt="Screenshot 2026-01-29 221333" src="https://github.com/user-attachments/assets/cf82e535-4a67-4c39-8b27-1a9d4dfad288" />


---

## 3️⃣ Add Event Form (Admin)

Form used to create new events with defined registration window.

<img width="1365" height="669" alt="Screenshot 2026-01-29 221409" src="https://github.com/user-attachments/assets/0f4c9864-7029-47ed-9c5a-1b6bc816d87b" />


---

## 4️⃣ Event Registration Form (User)

Public-facing dynamic registration form with AJAX-based filtering.

<img width="884" height="669" alt="Screenshot 2026-01-29 221513" src="https://github.com/user-attachments/assets/f4f96a55-dbb5-489b-8159-3d192e922bc7" />


---

## 5️⃣ Event Registrations Dashboard (Admin)

Admin panel displaying participant data with filters and CSV export option.

<img width="1365" height="663" alt="Screenshot 2026-01-29 221547" src="https://github.com/user-attachments/assets/5d9a9254-207d-45fb-9298-960d95d96116" />

---

## 6️⃣ Email Configuration Settings (Admin)

Admin interface for managing email notification settings.

<img width="1365" height="673" alt="Screenshot 2026-01-29 224110" src="https://github.com/user-attachments/assets/967d0982-c429-4c45-b6d0-8d650a3d7faa" />


---

# 👤 Author

**Anurag Thakur**  
📧 atanuragthakurpro@gmail.com  

---

# 📌 Project Positioning

This module demonstrates:

- Advanced Drupal backend engineering
- Clean architecture practices
- Service-based design
- Database schema design
- AJAX interaction handling
- Enterprise-ready structure
- Interview-grade production code

---

# 🏁 Status

✔ Fully Functional  
✔ Production Structured  
✔ Interview Ready  
✔ Scalable for Enterprise Use  



# 📜 License

This project is licensed under the MIT License.



## Drupal Version Tested

**Drupal 10.x**
