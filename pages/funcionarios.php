<?php
include '../includes/header.php'; 
include '../includes/db.php'; 

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
                        <a href="editar_funcionario.php?id=<?php echo $row['id']; ?>">Editar</a>
                        <a href="borrar_funcionario.php?id=<?php echo $row['id']; ?>">Borrar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    
    $sql = "INSERT INTO funcionarios (nombre, apellido, cargo) VALUES ('$nombre', '$apellido', '$cargo')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Funcionario agregado exitosamente.";
        header("Refresh:0"); // Recargar la página para mostrar el nuevo funcionario
    } else {
        echo "Error al agregar funcionario: " . $conn->error;
    }
}

include '../includes/footer.php'; 
?>
