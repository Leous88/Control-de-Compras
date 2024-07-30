<?php
include '../includes/header.php'; 
include '../includes/db.php'; 

// Verificar si se ha enviado una solicitud para eliminar un funcionario
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM funcionarios WHERE id = $delete_id");
    header("Location: funcionarios.php"); // Redirigir después de la eliminación
    exit;
}

// Verificar si se ha enviado una solicitud para actualizar un funcionario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    
    $sql = "UPDATE funcionarios SET nombre='$nombre', apellido='$apellido', cargo='$cargo' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Funcionario actualizado exitosamente.</p>";
        header("Refresh:0"); // Recargar la página para mostrar los cambios
        exit;
    } else {
        echo "<p>Error al actualizar funcionario: " . $conn->error . "</p>";
    }
}

// Verificar si se ha enviado una solicitud para agregar un nuevo funcionario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    
    $sql = "INSERT INTO funcionarios (nombre, apellido, cargo) VALUES ('$nombre', '$apellido', '$cargo')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Funcionario agregado exitosamente.</p>";
        header("Refresh:0"); // Recargar la página para mostrar el nuevo funcionario
        exit;
    } else {
        echo "<p>Error al agregar funcionario: " . $conn->error . "</p>";
    }
}

// Obtener la lista de funcionarios
$result = $conn->query("SELECT id, nombre, apellido, cargo FROM funcionarios");
?>

<div class="content">
    <h2>Administración de Funcionarios</h2>
    
    <h3>Agregar Nuevo Funcionario</h3>
    <form action="funcionarios.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        
        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo" required>
        
        <input type="submit" value="Agregar">
    </form>

    <h3>Lista de Funcionarios</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cargo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['cargo']; ?></td>
                    <td>
                        <!-- Botón para editar -->
                        <button onclick="showEditForm(<?php echo $row['id']; ?>)">Editar</button>
                        
                        <!-- Enlace para borrar -->
                        <a href="funcionarios.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres borrar este funcionario?');">Borrar</a>

                        <!-- Formulario para editar -->
                        <div id="edit-form-<?php echo $row['id']; ?>" class="edit-form" style="display:none;">
                            <form action="funcionarios.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <label for="edit-nombre-<?php echo $row['id']; ?>">Nombre:</label>
                                <input type="text" id="edit-nombre-<?php echo $row['id']; ?>" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                                
                                <label for="edit-apellido-<?php echo $row['id']; ?>">Apellido:</label>
                                <input type="text" id="edit-apellido-<?php echo $row['id']; ?>" name="apellido" value="<?php echo htmlspecialchars($row['apellido']); ?>" required>
                                
                                <label for="edit-cargo-<?php echo $row['id']; ?>">Cargo:</label>
                                <input type="text" id="edit-cargo-<?php echo $row['id']; ?>" name="cargo" value="<?php echo htmlspecialchars($row['cargo']); ?>" required>
                                
                                <input type="submit" name="update" value="Actualizar">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
include '../includes/footer.php'; 
?>

<!-- JavaScript para mostrar el formulario de edición -->
<script>
function showEditForm(id) {
    // Ocultar todos los formularios de edición
    var forms = document.getElementsByClassName('edit-form');
    for (var i = 0; i < forms.length; i++) {
        forms[i].style.display = 'none';
    }

    // Mostrar el formulario de edición específico
    var form = document.getElementById('edit-form-' + id);
    if (form) {
        form.style.display = 'block';
    }
}
</script>
