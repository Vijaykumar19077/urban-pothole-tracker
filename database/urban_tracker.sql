CREATE DATABASE IF NOT EXISTS urban_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE urban_tracker;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  phone VARCHAR(20) NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('citizen','admin') NOT NULL DEFAULT 'citizen',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS teams (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  team_name VARCHAR(100) NOT NULL,
  contact_person VARCHAR(100) NULL,
  phone VARCHAR(20) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS reports (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  title VARCHAR(150) NOT NULL,
  issue_type ENUM('Pothole','Damaged Road','Broken Streetlight','Open Manhole','Other') NOT NULL,
  location VARCHAR(255) NOT NULL,
  severity ENUM('Low','Moderate','Critical') NOT NULL,
  description TEXT NOT NULL,
  photo VARCHAR(255) NULL,
  status ENUM('Reported','Under Repair','Resolved') NOT NULL DEFAULT 'Reported',
  assigned_team_id INT UNSIGNED NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_reports_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_reports_team FOREIGN KEY (assigned_team_id) REFERENCES teams(id) ON DELETE SET NULL,
  INDEX idx_report_status (status),
  INDEX idx_report_severity (severity)
) ENGINE=InnoDB;

INSERT INTO teams (team_name,contact_person,phone)
SELECT 'Road Repair Team A','Maintenance Supervisor',''
WHERE NOT EXISTS (SELECT 1 FROM teams WHERE team_name='Road Repair Team A');
INSERT INTO teams (team_name,contact_person,phone)
SELECT 'Streetlight Maintenance Team','Electrical Supervisor',''
WHERE NOT EXISTS (SELECT 1 FROM teams WHERE team_name='Streetlight Maintenance Team');
INSERT INTO teams (team_name,contact_person,phone)
SELECT 'Emergency Road Team','Field Coordinator',''
WHERE NOT EXISTS (SELECT 1 FROM teams WHERE team_name='Emergency Road Team');
