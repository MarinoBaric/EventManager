<div align="center">

# 📅 Event Manager

**A role-based event management web application built with PHP (MVC) and MySQL.**

Browse events, register for the ones you like, and manage events, venues and users from a dedicated admin panel.

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-mod__rewrite-D22128?style=for-the-badge&logo=apache&logoColor=white)
![Architecture](https://img.shields.io/badge/Architecture-MVC-2ea44f?style=for-the-badge)

[Features](#-features) •
[Tech Stack](#-tech-stack) •
[Getting Started](#-getting-started) •
[Architecture](#-architecture) •
[Routes](#-routes) •
[Database](#-database)

</div>

---

## 📖 About

**Event Manager** is a web application for organizing events and the people who attend them. It is built from scratch on a custom, framework-free **Model–View–Controller** architecture with a front controller, URL router, class autoloader and a PDO-based data layer.

The application supports two roles:

- **Attendees** can browse all events, see event details, and register or unregister for events.
- **Admins** have full control over events, venues, users and the attendee list of every event.

> Built as a project for the **ISTE-341** course at **RIT**.

---

## ✨ Features

### 👤 Attendee

- 🔐 Create an account and log in
- 📋 Browse all upcoming events with their venue, dates and capacity
- 🔎 View the details of a single event
- ✅ Register for an event and ❌ unregister from it
- 🗂️ See all events you are registered for on the **My Events** page

### 🛠️ Admin

- 📅 **Events:** create, edit and delete events
- 🏟️ **Venues:** create, edit and delete venues with their capacity
- 👥 **Users:** create, edit and delete users and assign their role
- 🎟️ **Attendees:** view who is registered for an event, and add or remove attendees manually

### 🔒 Security

- Passwords hashed with `password_hash()` and checked with `password_verify()`
- All queries use **PDO prepared statements** to prevent SQL injection
- User input is trimmed, stripped of tags and escaped with `htmlspecialchars()`
- Server-side validation rules (required fields, length limits, regex) defined per model
- Role checks on every admin action
- Sessions expire automatically after a configurable period of inactivity

---

## 🧰 Tech Stack

| Layer        | Technology                                       |
| ------------ | ------------------------------------------------ |
| Language     | PHP 8.0+ (object-oriented, typed)                |
| Database     | MySQL / MariaDB via PDO                          |
| Web server   | Apache with `mod_rewrite`                        |
| Architecture | Custom MVC (front controller, router, autoload)  |
| Frontend     | Server-rendered PHP views, HTML5, CSS3           |

---

## 🚀 Getting Started

### Prerequisites

- [XAMPP](https://www.apachefriends.org/), MAMP or any Apache + PHP + MySQL stack
- PHP **8.0** or newer
- Apache `mod_rewrite` enabled with `AllowOverride All` (so `.htaccess` is applied)

### Installation

**1. Clone the repository** into your web server root (e.g. `htdocs` in XAMPP):

```bash
git clone https://github.com/MarinoBaric/EventManager.git Project1
```

**2. Create the database** by importing the SQL dump. It creates the `em` database with its tables and sample data:

```bash
mysql -u root -p < Project1/assets/em.sql
```

Or import `assets/em.sql` through **phpMyAdmin**.

**3. Create your config file** from the example:

```bash
cp Project1/app/config/config.example.ini Project1/app/config/config.ini
```

**4. Open the app** in your browser:

```
http://localhost/Project1
```

> [!NOTE]
> The app expects to live in a folder called `Project1`. If you use a different folder name, update `RewriteBase` in [`.htaccess`](.htaccess) and `project_url` in `app/config/config.ini`.

### ⚙️ Configuration

All settings live in `app/config/config.ini`:

```ini
[db]
dsn = 'mysql:host=localhost;dbname=em'
username = 'root'
password = ''

[app]
project_url = "http://localhost/Project1"

[session]
session_timeout = 300   ; seconds of inactivity before logout
```

> [!IMPORTANT]
> `config.ini` is listed in `.gitignore` so your database credentials are never committed. Only `config.example.ini` is tracked.

### 🔑 Demo Accounts

The sample data includes admin and attendee accounts. Their usernames and passwords are listed in [`assets/passwords.txt`](assets/passwords.txt). You can also register a new attendee account from the login page.

---

## 🏗️ Architecture

### Request Lifecycle

```
Browser ──▶ .htaccess ──▶ Index.php ──▶ Router ──▶ Controller ──▶ Model ──▶ MySQL
                                                       │
                                                       ▼
                                                     View ──▶ HTML response
```

1. **`.htaccess`** rewrites every request for a non-existing file to `Index.php`.
2. **`Index.php`** (front controller) loads the config, registers the class autoloader, starts the session and hands the request to the router.
3. **`Router`** parses the URL `/controller/action/param1/param2` and calls the matching controller method.
4. **Controllers** check the session and role, talk to the models and pass the data to a view.
5. **Models** validate and sanitize input and run prepared queries through the base `Model` class.
6. **Views** render the HTML using the shared header and footer.

### Project Structure

```
Project1/
├── .htaccess                   # Rewrites all requests to Index.php
├── Index.php                   # Front controller and autoloader
├── app/
│   ├── config/
│   │   └── config.example.ini  # Config template (copy to config.ini)
│   ├── controller/
│   │   ├── Controller.php      # Base controller (views, models, session timeout)
│   │   ├── UserController.php  # Login, registration, logout
│   │   ├── EventController.php # Event list, details, registration
│   │   └── AdminController.php # Event, venue, user and attendee management
│   ├── model/
│   │   ├── Model.php           # Base model (PDO, validation, sanitizing)
│   │   ├── UserModel.php
│   │   ├── EventModel.php
│   │   ├── VenueModel.php
│   │   └── RoleModel.php
│   ├── router/
│   │   └── Router.php          # Maps URLs to controller actions
│   ├── service/
│   │   └── Session.php         # Session start, destroy and expiry
│   └── view/
│       ├── inc/                # Shared header and footer
│       ├── user/               # Login and registration
│       ├── event/              # Event list, details, my events, attendees
│       └── admin/              # Admin dashboard and CRUD forms
├── assets/
│   ├── em.sql                  # Database schema and sample data
│   └── passwords.txt           # Demo account credentials
└── public/
    └── css/style.css           # Stylesheet
```

---

## 🧭 Routes

URLs follow the pattern **`/controller/action/params`**. The default route is `/user/login`.

<details>
<summary><b>👤 User</b></summary>

| Route               | Method | Description                  |
| ------------------- | ------ | ---------------------------- |
| `/user/login`       | GET    | Login form                   |
| `/user/welcome`     | POST   | Log in and redirect by role  |
| `/user/register`    | GET    | Registration form            |
| `/user/insertuser`  | POST   | Create a new attendee        |
| `/user/logout`      | GET    | End the session              |

</details>

<details>
<summary><b>📅 Events</b></summary>

| Route                          | Method | Description                          |
| ------------------------------ | ------ | ------------------------------------ |
| `/event/events`                | GET    | List all events                      |
| `/event/myevents`              | GET    | Events the user is registered for    |
| `/event/eventdetails/{id}`     | GET    | Event details                        |
| `/event/registered/{id}`       | GET    | Attendees registered for an event    |
| `/event/registerevent/{id}`    | GET    | Register for an event                |
| `/event/unregisterevent/{id}`  | GET    | Unregister from an event             |

</details>

<details>
<summary><b>🛠️ Admin</b></summary>

| Route                                     | Method | Description                  |
| ----------------------------------------- | ------ | ---------------------------- |
| `/admin/admin`                            | GET    | Admin dashboard (all events) |
| `/admin/addevent`                         | GET    | New event form               |
| `/admin/insertevent`                      | POST   | Create an event              |
| `/admin/editevent/{id}`                   | GET    | Edit event form              |
| `/admin/updateevent`                      | POST   | Update an event              |
| `/admin/deleteevent/{id}`                 | GET    | Delete an event              |
| `/admin/venues`                           | GET    | List all venues              |
| `/admin/addvenue`                         | GET    | New venue form               |
| `/admin/insertvenue`                      | POST   | Create a venue               |
| `/admin/editvenue/{id}`                   | GET    | Edit venue form              |
| `/admin/updatevenue`                      | POST   | Update a venue               |
| `/admin/deletevenue/{id}`                 | GET    | Delete a venue               |
| `/admin/users`                            | GET    | List all users               |
| `/admin/adduser`                          | GET    | New user form                |
| `/admin/insertuser`                       | POST   | Create a user                |
| `/admin/edituser/{id}`                    | GET    | Edit user form               |
| `/admin/updateuser`                       | POST   | Update a user                |
| `/admin/deleteuser/{id}`                  | GET    | Delete a user                |
| `/admin/addattendee`                      | POST   | Add an attendee to an event  |
| `/admin/removeattendee/{event}/{user}`    | GET    | Remove an attendee           |

</details>

---

## 🗄️ Database

The `em` database has five tables:

```
role ──< attendee >──< attendee_event >──< event >── venue
```

| Table            | Description                                                      |
| ---------------- | ---------------------------------------------------------------- |
| `role`           | User roles (`admin`, `attendee`)                                 |
| `attendee`       | Users with name, email, username, hashed password and role       |
| `venue`          | Event locations with their capacity                              |
| `event`          | Events with name, start and end date, allowed number and venue   |
| `attendee_event` | Many-to-many link between attendees and the events they attend   |

---

## 👨‍💻 Author

**Marino Barić**

[![GitHub](https://img.shields.io/badge/GitHub-MarinoBaric-181717?style=flat-square&logo=github)](https://github.com/MarinoBaric)

---

<div align="center">

⭐ If you found this project useful, consider giving it a star!

</div>
