# Appointment Management System - Dr. Dupont Dental Office

## Description
PHP/MySQL web application for managing appointments at Dr. Dupont's dental office.

## Project Structure
```
DENTISTE/
├── config/           # Configuration (database, app)
├── src/             # Object-oriented PHP code
│   ├── Models/      # Business classes
│   ├── Controllers/ # Controllers
│   └── Utils/       # Utilities
├── public/          # Entry point (index.php)
├── templates/       # HTML/PHP views
│   ├── front/       # Public pages
│   └── admin/       # Back office
├── assets/          # CSS, JS, images
├── sql/             # Database schema
└── docs/            # Documentation and UML diagrams
```

## Installation

1. **Import the database**
```bash
mysql -u root -p < sql/schema.sql
```

2. **Configure the application**
Edit `config/database.php` with your MySQL credentials.

3. **Access the application**
- Front office: http://localhost/DENTISTE/
- Back office: http://localhost/DENTISTE/admin
- Default credentials: admin@cabinet-dupont.fr / Admin123!

## Features

### Front Office
- Homepage with office presentation
- Online appointment booking
- Services presentation
- About page
- News section

### Back Office
- Appointment management
- Services management
- News management
- Patient management
- Schedule management

## Technologies
- PHP 8.0+ (OOP)
- MySQL 8.0+
- HTML5 / CSS3
- Responsive design

## Security
- Hashed passwords (PASSWORD_DEFAULT)
- CSRF protection
- Prepared statements (PDO)
- Data validation
- Secure sessions

## Author
Project developed as part of a backend web and mobile development training program.
