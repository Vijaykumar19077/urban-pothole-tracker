# Urban Pothole & Road Infrastructure Damage Reporting Tracker

A PHP and MySQL web application for citizens to report road hazards and for municipal administrators to coordinate maintenance.

## Technology
- HTML5, CSS3, JavaScript
- PHP 8+
- MySQL / MariaDB
- Apache (XAMPP)
- Git and GitHub

## Local setup
1. Install XAMPP and start Apache and MySQL.
2. Copy this folder into `C:\xampp\htdocs\urban-pothole-tracker`.
3. Open `http://localhost/phpmyadmin`.
4. Import `database/urban_tracker.sql`.
5. Check database credentials in `includes/db.php` (default XAMPP: user `root`, blank password).
6. Make sure the `uploads` folder exists and is writable by PHP.
7. Open `http://localhost/urban-pothole-tracker/`.

## Create an administrator
1. Register a normal account using the website.
2. Open phpMyAdmin and select `urban_tracker`.
3. Open the SQL tab and run the following, replacing the email with the account email you registered:

```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

4. Log out and log in again. The Admin panel link will appear.

## Features
- Citizen account registration and login
- Road hazard reports with location, issue type, severity, description and photo
- Citizen report history
- Public report dashboard with search and filters
- Admin overview and report management
- Maintenance team assignment
- Report status updates

## Notes
- This is a college-project starter intended for local demonstration.
- Use realistic but non-sensitive sample data.
- Before public deployment, configure HTTPS, stronger upload isolation, CSRF protection, rate limiting, backups and production database credentials.
- Uploaded image files are stored in `uploads/`; the database stores the generated filename.
