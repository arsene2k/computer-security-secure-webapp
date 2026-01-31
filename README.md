Secure Web Application — Computer Security Project

A PHP-based secure web application demonstrating practical defenses against common web vulnerabilities, including secure authentication, access control, and cloud-aware security design.

Developed as a final-year Computer Science project with an emphasis on real-world security implementation, rather than theory alone.

Key Features

Secure user registration and authentication

Password hashing and strength enforcement

Email verification and Two-Factor Authentication (2FA)

Password recovery using security questions

Role-based access control (admin and standard users)

Secure form handling and file uploads

CSRF attack proof-of-concept and testing

AWS VPC security design (documented)

Security Focus

SQL Injection prevention using prepared statements

Cross-Site Scripting (XSS) mitigation through input and output sanitization

CSRF awareness and controlled testing

Secure session management

Restricted and monitored admin access

Project Structure

src/auth/ – Authentication and account recovery logic

src/admin/ – Admin-only functionality

src/features/ – Core application features

src/security-tests/ – Security testing scripts and proof-of-concepts

db/ – Database schema

docs/ – Project report and supporting documentation

Running the Project

This project is intended for local testing using a PHP server environment such as XAMPP.

Import the database schema from db/mycustomdb.sql

Configure database credentials (placeholders recommended)

Serve the application via Apache

Access the application through a web browser