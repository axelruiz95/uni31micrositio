-- database.sql
-- Cree primero la base de datos (ajuste el nombre si lo desea)
CREATE DATABASE IF NOT EXISTS micrositio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE micrositio_db;

-- Tabla 'Clientes'
CREATE TABLE IF NOT EXISTS Clientes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  domicilio VARCHAR(255) NOT NULL,
  telefono VARCHAR(30) NOT NULL,
  email VARCHAR(180) NOT NULL,
  comentarios TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
