-- Création de la base de données
CREATE DATABASE IF NOT EXISTS dentiste CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dentiste;

-- Table des utilisateurs (admin, équipe et patients)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'staff', 'patient') DEFAULT 'patient',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des patients
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date_of_birth DATE,
    gender ENUM('M', 'F', 'other') DEFAULT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_name (last_name, first_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des services
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    duration INT NOT NULL COMMENT 'Durée en minutes',
    price DECIMAL(10, 2),
    is_active BOOLEAN DEFAULT TRUE,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (is_active, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des rendez-vous
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    service_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT,
    INDEX idx_date (appointment_date, appointment_time),
    INDEX idx_status (status),
    INDEX idx_patient (patient_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des actualités
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    excerpt VARCHAR(500),
    author_id INT,
    is_published BOOLEAN DEFAULT FALSE,
    published_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_published (is_published, published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des horaires d'ouverture
CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day_of_week ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche') NOT NULL,
    opening_time TIME NOT NULL,
    closing_time TIME NOT NULL,
    is_closed BOOLEAN DEFAULT FALSE,
    UNIQUE KEY unique_day (day_of_week)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion d'un utilisateur admin par défaut
-- Mot de passe: Admin123!
INSERT INTO users (email, password, name, role) VALUES
('admin@cabinet-dupont.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrateur', 'admin');

-- Insertion de services par défaut
INSERT INTO services (title, description, duration, price, display_order) VALUES
('Consultation générale', 'Examen dentaire complet avec nettoyage', 30, 50.00, 1),
('Détartrage', 'Nettoyage professionnel et détartrage', 45, 70.00, 2),
('Soin de carie', 'Traitement et obturation d''une carie', 60, 90.00, 3),
('Extraction dentaire', 'Extraction simple d''une dent', 45, 80.00, 4),
('Blanchiment dentaire', 'Traitement de blanchiment professionnel', 90, 250.00, 5),
('Pose de couronne', 'Pose d''une couronne dentaire', 120, 600.00, 6),
('Orthodontie - Consultation', 'Première consultation orthodontique', 45, 60.00, 7),
('Implant dentaire', 'Pose d''un implant dentaire', 120, 1200.00, 8);

-- Insertion des horaires par défaut
INSERT INTO schedules (day_of_week, opening_time, closing_time, is_closed) VALUES
('Lundi', '09:00:00', '18:00:00', FALSE),
('Mardi', '09:00:00', '18:00:00', FALSE),
('Mercredi', '09:00:00', '18:00:00', FALSE),
('Jeudi', '09:00:00', '18:00:00', FALSE),
('Vendredi', '09:00:00', '18:00:00', FALSE),
('Samedi', '09:00:00', '12:00:00', TRUE),
('Dimanche', '09:00:00', '12:00:00', TRUE);

-- Insertion d'actualités exemples
INSERT INTO news (title, content, excerpt, author_id, is_published, published_at) VALUES
('Bienvenue sur notre nouveau site', 'Nous sommes ravis de vous présenter notre nouveau site web qui vous permettra de prendre rendez-vous en ligne facilement. Notre cabinet s''engage à vous offrir les meilleurs soins dentaires dans un environnement moderne et confortable.', 'Découvrez notre nouveau site et prenez rendez-vous en ligne', 1, TRUE, NOW()),
('L''importance du détartrage régulier', 'Le détartrage est un soin essentiel pour maintenir une bonne hygiène bucco-dentaire. Il est recommandé de faire un détartrage tous les 6 mois pour prévenir les maladies parodontales et garder des dents saines.', 'Pourquoi le détartrage est-il si important pour votre santé dentaire ?', 1, TRUE, NOW());
