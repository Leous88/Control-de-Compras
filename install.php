<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";  // Cambia esto según tu configuración
$password = "";      // Cambia esto según tu configuración
$dbname = "mi_base_de_datos"; // Cambia esto según el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comandos SQL para crear tablas
$sql = "
CREATE TABLE IF NOT EXISTS funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    cargo VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS solicitud_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_solicitud VARCHAR(50) NOT NULL,
    solicitante_id INT,
    fecha DATE NOT NULL,
    unidad VARCHAR(255) NOT NULL,
    origen ENUM('presupuesto_salud', 'convenio') NOT NULL,
    FOREIGN KEY (solicitante_id) REFERENCES funcionarios(id)
);

CREATE TABLE IF NOT EXISTS requerimiento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitud_id INT,
    cantidad INT NOT NULL,
    producto VARCHAR(255) NOT NULL,
    FOREIGN KEY (solicitud_id) REFERENCES solicitud_compra(id)
);
";

// Ejecutar los comandos SQL
if ($conn->multi_query($sql)) {
    do {
        // almacenar el primer conjunto de resultados
        if ($result = $conn->store_result()) {
            $result->free();
        }
        // imprimir un mensaje de éxito
        echo "Tablas creadas exitosamente.<br>";
    } while ($conn->more_results() && $conn->next_result());
} else {
    echo "Error al crear tablas: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
