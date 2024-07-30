<?php
include 'config.php';
?>
<div class="sidebar">
<nav>
    <ul>
        <li><a href="<?php echo BASE_URL; ?>index.php">Inicio</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/solicitud_compra.php">Solicitud de Compra</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/medio_compra.php">Medio de Compra</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/orden_compra.php">Orden de Compra</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/recepcion_productos.php">Recepción de Productos</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/documentos_pago.php">Documentos de Pago</a></li>
        <li><a href="<?php echo BASE_URL; ?>pages/seguimiento_pago.php">Seguimiento de Pago</a></li>
        
        <!-- Menú de Administración -->
        <li>
            <a href="#">Administración</a>
            <ul class="submenu">
                <li><a href="<?php echo BASE_URL; ?>pages/funcionarios.php">Funcionarios</a></li>
            </ul>
        </li>
    </ul>
</nav>
</div>
