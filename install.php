<?php
// Configuración de la Base de Datos
$servername = "localhost";
$username = "apssanra_compras";
$password = "apssanra_compras";
$dbname = "apssanra_compras";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Crear base de datos
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada exitosamente<br>";
} else {
    echo "Error creando base de datos: " . $conn->error . "<br>";
}

// Seleccionar base de datos
$conn->select_db($dbname);

// Crear tabla 'funcionarios'
$sql = "CREATE TABLE IF NOT EXISTS funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    cargo VARCHAR(100) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'funcionarios' creada exitosamente<br>";
} else {
    echo "Error creando tabla 'funcionarios': " . $conn->error . "<br>";
}

// Crear tabla 'solicitud_compra'
$sql = "CREATE TABLE IF NOT EXISTS solicitud_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_solicitud VARCHAR(50) NOT NULL,
    solicitante_id INT NOT NULL,
    fecha DATE NOT NULL,
    unidad VARCHAR(100) NOT NULL,
    origen VARCHAR(100) NOT NULL,
    fecha_recepcion DATE NOT NULL,
    FOREIGN KEY (solicitante_id) REFERENCES funcionarios(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'solicitud_compra' creada exitosamente<br>";
} else {
    echo "Error creando tabla 'solicitud_compra': " . $conn->error . "<br>";
}

// Crear tabla 'requerimiento'
$sql = "CREATE TABLE IF NOT EXISTS requerimiento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitud_id INT NOT NULL,
    cantidad INT NOT NULL,
    producto VARCHAR(255) NOT NULL,
    FOREIGN KEY (solicitud_id) REFERENCES solicitud_compra(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'requerimiento' creada exitosamente<br>";
} else {
    echo "Error creando tabla 'requerimiento': " . $conn->error . "<br>";
}

// Cerrar conexión
$conn->close();
?>
