# TSG MVC - Custom PHP MVC Framework & Student Management Portal

A lightweight, secure, and modern Object-Oriented PHP Web Application built following the Model-View-Controller (MVC) architectural design pattern.

Developed as part of the **Tech SG Studio Web Development Internship Program**.

---

## 🚀 Key Features

* **Custom MVC Architecture:** Clean separation of concerns with Front Controller (`index.php`) and Apache `.htaccess` URL rewriting[cite: 9, 10].
* **Role-Based Authentication (RBAC):** Admin and User role authorization with secure password hashing (`password_hash`) and session control.
* **Complete Student CRUD System:** Create, Read, Update, and Delete student records with real-time search, pagination, and course associations.
* **Secure File Uploads:** Validated profile photo uploads (MIME type check, file size restriction, unique filename generation).
* **RESTful API Endpoint:** Built-in JSON API (`/api/students`) returning structured student data and image URLs.
* **Security Enhancements:** CSRF token verification, XSS input sanitization, PDO prepared statements against SQL Injection, and Admin-only deletion rights[cite: 11, 12].

---

## 🛠️ Technology Stack

* **Language:** PHP 8+ (Pure OOP)
* **Database:** MySQL / MariaDB (Port 3307 support via PDO)[cite: 3, 11]
* **Server:** Apache (XAMPP Server)
* **Frontend:** Clean Responsive CSS3 with Google Inter Font[cite: 14]

---

## 📁 Project Directory Structure

```text
tsg-mvc/
├── app/
│   ├── Controllers/
│   │   ├── AboutController.php
│   │   ├── ApiController.php
│   │   ├── AuthController.php
│   │   ├── CoursesController.php
│   │   ├── HomeController.php
│   │   └── StudentsController.php
│   ├── Core/
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   ├── Model.php
│   │   └── Router.php
│   ├── Models/
│   │   ├── Course.php
│   │   ├── Student.php
│   │   └── User.php
│   └── Views/
│       ├── auth/
│       ├── layout/
│       ├── students/
│       ├── about.php
│       ├── courses.php
│       └── home.php
├── config/
│   └── config.php
├── public/
│   ├── uploads/
│   ├── .htaccess
│   └── index.php
├── database.sql
└── README.md