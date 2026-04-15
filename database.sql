-- Base de datos necesaria para GasCare Senior
CREATE DATABASE gascare_db;

USE gascare_db;

-- Tabla de registros enviados desde el formulario
CREATE TABLE registros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  direccion VARCHAR(255),
  telefono VARCHAR(50),
  habitante1_nombre VARCHAR(100),
  habitante1_apellido VARCHAR(100),
  habitante2_nombre VARCHAR(100),
  habitante2_apellido VARCHAR(100),
  correo_familiar VARCHAR(150),
  lectura_gas INT,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);