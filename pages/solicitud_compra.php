<?php 
include '../includes/header.php'; 
include '../includes/db.php'; 
?>

<div class="content">
    <h2>Solicitud de Compra</h2>
    <form action="solicitud_compra.php" method="POST">
        <fieldset>
            <legend>Datos del Solicitante</legend>
            
            <label for="solicitante">Nombre del Solicitante:</label>
            <input type="text" id="solicitante" name="solicitante" required>
            
            <label for="fecha">Fecha de la Solicitud:</label>
            <input type="date" id="fecha" name="fecha" required>
            
            <label for="unidad">Unidad de Origen:</label>
            <input type="text" id="unidad" name="unidad" required>
            
            <label for="origen">Origen del Requerimiento:</label>
            <select id="origen" name="origen" required>
                <option value="presupuesto_salud">Presupuesto Salud</option>
                <option value="convenio">Convenio</option>
            </select>
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
        $solicitante = $_POST['solicitante'];
        $fecha = $_POST['fecha'];
        $unidad = $_POST['unidad'];
        $origen = $_POST['origen'];
        
        // Insertar en la tabla solicitud_compra
        $sql = "INSERT INTO solicitud_compra (solicitante, fecha, unidad, origen) VALUES ('$solicitante', '$fecha', '$unidad', '$origen')";
        
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