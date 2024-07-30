<?php
include '../includes/header.php'; 
include '../includes/db.php'; 

// Verificar si se ha enviado una solicitud para agregar un nuevo requerimiento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $solicitante_id = $_POST['solicitante'];
    $numero_solicitud = $_POST['numero_solicitud'];
    $unidad = $_POST['unidad'];
    $origen_requerimiento = $_POST['origen_requerimiento'];
    $fecha_recepcion = date('Y-m-d'); // Fecha actual
    
    // Asumimos que la tabla tiene columnas para los detalles del requerimiento
    $sql = "INSERT INTO solicitud_compra (solicitante_id, numero_solicitud, unidad, origen_requerimiento, fecha_recepcion) VALUES ('$solicitante_id', '$numero_solicitud', '$unidad', '$origen_requerimiento', '$fecha_recepcion')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Solicitud de compra agregada exitosamente.</p>";
    } else {
        echo "<p>Error al agregar solicitud de compra: " . $conn->error . "</p>";
    }
}

// Obtener la lista de funcionarios para el campo de solicitante
$funcionarios = $conn->query("SELECT id, nombre, apellido FROM funcionarios");
?>

<div class="content">
    <h2>Solicitud de Compra</h2>
    
    <form action="solicitud_compra.php" method="POST">
        <label for="solicitante">Solicitante:</label>
        <select id="solicitante" name="solicitante" required>
            <?php while ($row = $funcionarios->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label for="numero_solicitud">Número de Solicitud:</label>
        <input type="text" id="numero_solicitud" name="numero_solicitud" required>
        
        <label for="unidad">Unidad de Origen:</label>
        <input type="text" id="unidad" name="unidad" required>
        
        <label for="origen_requerimiento">Origen del Requerimiento:</label>
        <select id="origen_requerimiento" name="origen_requerimiento" required>
            <option value="presupuesto Salud">Presupuesto Salud</option>
            <option value="convenio">Convenio</option>
            <!-- Agregar más opciones si es necesario -->
        </select>
        
        <!-- La fecha de recepción se establece automáticamente -->
        <input type="hidden" name="fecha_recepcion" value="<?php echo date('Y-m-d'); ?>">
        
        <input type="submit" value="Enviar Solicitud">
    </form>
</div>

<?php
include '../includes/footer.php'; 
?>
