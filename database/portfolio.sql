-- ======================================
-- Personal Portfolio Database
-- ======================================

CREATE DATABASE IF NOT EXISTS portfolio;

USE portfolio;


-- ======================================
-- ADMIN TABLE
-- ======================================

CREATE TABLE admin (

    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL,

    password VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);



-- Default Admin Account
-- Password: admin123

INSERT INTO admin
(username,email,password)

VALUES

(
'admin',
'admin@gmail.com',
'admin123'
);



-- ======================================
-- PROFILE TABLE
-- ======================================

CREATE TABLE profile (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100),

    role VARCHAR(100),

    about TEXT,

    email VARCHAR(150),

    phone VARCHAR(20),

    location VARCHAR(150),

    resume VARCHAR(255)

);



INSERT INTO profile
(name,role,about,email,phone,location)

VALUES

(
'Paruchuru Chanikya',
'Full Stack Developer',
'Computer Science student passionate about web development and software engineering.',
'yourmail@example.com',
'+91 XXXXX XXXXX',
'Andhra Pradesh, India'
);



-- ======================================
-- PROJECT TABLE
-- ======================================

CREATE TABLE projects (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(200),

    description TEXT,

    technology VARCHAR(255),

    image VARCHAR(255),

    github VARCHAR(255),

    demo VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);



INSERT INTO projects
(title,description,technology)

VALUES

(
'Inventory Management System',
'Complete inventory management application with product and stock management.',
'HTML CSS JavaScript PHP MySQL'
),


(
'Disaster Management System',
'Emergency management website with maps and alerts.',
'HTML CSS JavaScript Leaflet'
),


(
'Gaming Hub',
'Collection of multiple browser games.',
'HTML CSS JavaScript'
);



-- ======================================
-- SKILLS TABLE
-- ======================================

CREATE TABLE skills (

    id INT AUTO_INCREMENT PRIMARY KEY,

    skill_name VARCHAR(100),

    percentage INT,

    category VARCHAR(100)

);



INSERT INTO skills
(skill_name,percentage,category)

VALUES

('Java',90,'Programming'),

('HTML',95,'Frontend'),

('CSS',90,'Frontend'),

('JavaScript',85,'Frontend'),

('PHP',80,'Backend'),

('MySQL',85,'Database');



-- ======================================
-- CERTIFICATES TABLE
-- ======================================

CREATE TABLE certificates (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(200),

    issuer VARCHAR(200),

    certificate_image VARCHAR(255),

    certificate_pdf VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);



INSERT INTO certificates
(title,issuer)

VALUES

(
'Java Programming Certificate',
'Online Platform'
),

(
'Web Development Certificate',
'Online Platform'
);



-- ======================================
-- CONTACT MESSAGES TABLE
-- ======================================

CREATE TABLE contact_messages (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100),

    email VARCHAR(150),

    subject VARCHAR(200),

    message TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);



-- ======================================
-- END DATABASE
-- ======================================



