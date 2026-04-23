<?php
// Archivo de conexión a la base de datos MySQL para GasCare Senior
// Este archivo establece la conexión con la base de datos usando mysqli

// Configuración de la conexión a la base de datos
$host = "localhost"; // Dirección del servidor de la base de datos
$user = "root"; // Usuario de la base de datos
$password = ""; // Contraseña del usuario (vacía por defecto en XAMPP)
$db = "gascare_db"; // Nombre de la base de datos

// Crear una nueva conexión mysqli
$conn = new mysqli($host, $user, $password, $db);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    // Mostrar mensaje de error y terminar el script si falla la conexión
    die("Error de conexión: " . $conn->connect_error);
}
?>