<?php 
include '../includes/header.php'; 
include '../includes/db.php'; 
?>

<div class="content">
    <h2>Solicitud de Compra</h2>
    <form action="solicitud_compra.php" method="POST">
        <fieldset>
            <legend>Datos del Solicitante</legend>
            
            <label for="numero_solicitud">Número de Solicitud:</label>
            <input type="text" id="numero_solicitud" name="numero_solicitud" required>
            
            <label for="solicitante">Nombre del Solicitante:</label>
            <select id="solicitante" name="solicitante" required>
                <?php
                // Obtener la lista de funcionarios
                $result = $conn->query("SELECT id, nombre FROM funcionarios");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"{$row['id']}\">{$row['nombre']}</option>";
                }
                ?>
            </select>
            
            <label for="fecha">Fecha de la Solicitud:</label>
            <input type="date" id="fecha" name="fecha" required>
            
            <label for="unidad">Unidad de Origen:</label>
            <input type="text" id="unidad" name="unidad" required>
            
            <label for="origen">Origen del Requerimiento:</label>
            <select id="origen" name="origen" required>
                <option value="presupuesto_salud">Presupuesto Salud</option>
                <option value="convenio">Convenio</option>
            </select>

            <label for="fecha_recepcion">Fecha de Recepción:</label>
            <input type="date" id="fecha_recepcion" name="fecha_recepcion" value="<?php echo date('Y-m-d'); ?>">
        </fieldset>
        
        <fieldset>
            <legend>Listado de Requerimientos</legend>
            
            <div id="requerimientos">
                <div class="requerimiento">
                    <label for="cantidad_1">Cantidad:</label>
                    <input type="number" id="cantidad_1" name="cantidad[]" required>
                    
                    <label for="producto_1">Producto:</label>
                    <input type="text" id="producto_1" name="producto[]" required>
                </div>
            </div>
            
            <button type="button" onclick="addRequerimiento()">Agregar Requerimiento</button>
        </fieldset>
        
        <input type="submit" value="Enviar">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Datos de la solicitud
        $numero_solicitud = $_POST['numero_solicitud'];
        $solicitante_id = $_POST['solicitante'];
        $fecha = $_POST['fecha'];
        $unidad = $_POST['unidad'];
        $origen = $_POST['origen'];
        $fecha_recepcion = $_POST['fecha_recepcion'];
        
        // Insertar en la tabla solicitud_compra
        $sql = "INSERT INTO solicitud_compra (numero_solicitud, solicitante_id, fecha, unidad, origen, fecha_recepcion) VALUES ('$numero_solicitud', '$solicitante_id', '$fecha', '$unidad', '$origen', '$fecha_recepcion')";
        
        if ($conn->query($sql) === TRUE) {
            $solicitud_id = $conn->insert_id;
            
            // Datos del requerimiento
            $cantidades = $_POST['cantidad'];
            $productos = $_POST['producto'];
            
            foreach ($cantidades as $index => $cantidad) {
                $producto = $productos[$index];
                $sql = "INSERT INTO requerimiento (solicitud_id, cantidad, producto) VALUES ('$solicitud_id', '$cantidad', '$producto')";
                
                if (!$conn->query($sql)) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            
            echo "Nueva solicitud creada exitosamente.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>
</div>

<script>
function addRequerimiento() {
    var container = document.getElementById("requerimientos");
    var count = container.getElementsByClassName("requerimiento").length + 1;
    var div = document.createElement("div");
    div.className = "requerimiento";
    div.innerHTML = `
        <label for="cantidad_${count}">Cantidad:</label>
        <input type="number" id="cantidad_${count}" name="cantidad[]" required>
        
        <label for="producto_${count}">Producto:</label>
        <input type="text" id="producto_${count}" name="producto[]" required>
    `;
    container.appendChild(div);
}
</script>

<?php include '../includes/footer.php'; ?>
