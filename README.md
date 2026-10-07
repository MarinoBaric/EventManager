# Event Manager

Event management web app built with PHP (MVC) and MySQL.

Attendees can register, log in, browse events and sign up for them.
Admins can manage events, venues, users and event attendees.

## Setup

1. Put the project in your web server root (e.g. `htdocs/Project1` in XAMPP).
2. Import `assets/em.sql` into MySQL (creates the `em` database).
3. Copy `app/config/config.example.ini` to `app/config/config.ini` and set your database credentials and `project_url`.
4. If the folder name is not `Project1`, update `RewriteBase` in `.htaccess`.
5. Open `http://localhost/Project1`.

Test accounts are listed in `assets/passwords.txt`.
