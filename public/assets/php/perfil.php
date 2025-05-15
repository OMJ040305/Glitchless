<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    // Si no hay sesión activa, redirigir al login
    header("Location: login.php");
    exit();
}

include '../../../includes/conexionBD.php'; // Incluir la conexión establecida con mysqli

// Preparar la consulta para obtener la información del usuario usando el ID
$query = "SELECT id, nombre_completo, correo, usuario FROM usuarios WHERE id = ?";
$stmt = mysqli_prepare($conexion, $query);

// Verificar si la preparación fue exitosa
if ($stmt === false) {
    die("Error al preparar la consulta: " . mysqli_error($conexion));
}

// Asociar los parámetros - Usamos el ID del usuario en lugar del correo
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['usuario_id']); // 'i' indica que es un parámetro integer (id)

// Ejecutar la consulta
mysqli_stmt_execute($stmt);

// Obtener los resultados
$result = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($result);

// Verificar si se encontró el usuario
if (!$usuario) {
    die("Usuario no encontrado.");
}

// Obtener las direcciones del usuario
$query_direcciones = "SELECT * FROM direcciones WHERE usuario_id = ?";
$stmt_direcciones = mysqli_prepare($conexion, $query_direcciones);

if ($stmt_direcciones === false) {
    die("Error al preparar la consulta de direcciones: " . mysqli_error($conexion));
}

mysqli_stmt_bind_param($stmt_direcciones, 'i', $_SESSION['usuario_id']); // Usar directamente el ID de la sesión
mysqli_stmt_execute($stmt_direcciones);
$result_direcciones = mysqli_stmt_get_result($stmt_direcciones);

// Cerrar las declaraciones
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmt_direcciones);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil - Glitchless</title>
    <link rel="stylesheet" href="../css/stylePerfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<header class="header">
    <div class="menu container">
        <a href="../../index.php" class="logo">Glitchless</a>
        <nav class="navbar">
            <ul>
                <li><a href="../../index.php#top">Inicio</a></li>
                <li><a href="../../index.php#productos">Productos</a></li>
                <li><a href="../../index.php#blog">Blog</a></li>
                <li><a href="../../index.php#contacto">Contacto</a></li>
            </ul>
        </nav>
    </div>
</header>

<section class="perfil container">
    <div class="perfil-header">
        <h2>Hola, <?= htmlspecialchars($usuario['nombre_completo']) ?></h2>
        <form method="POST" action="../../../includes/cerrar_sesion.php" class="perfil-logout">
            <button class="btn-logout">Cerrar sesión</button>
        </form>
    </div>

    <div class="perfil-menu">
        <button class="tab-button active" data-tab="info">Información personal</button>
        <button class="tab-button" data-tab="pedidos">Mis pedidos</button>
        <button class="tab-button" data-tab="direccion">Dirección</button>
    </div>

    <div class="perfil-content">
        <div class="tab-content active" id="info">
            <h3>Datos personales</h3>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre_completo']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario['correo']) ?></p>
            <p><strong>Usuario:</strong> <?= htmlspecialchars($usuario['usuario']) ?></p>
        </div>

        <div class="tab-content" id="pedidos">
            <h3>Mis pedidos</h3>
            <p>No hay pedidos recientes.</p>
        </div>

        <div class="tab-content" id="direccion">
            <h3>Mis direcciones</h3>

            <div class="direcciones-container">
                <?php
                if (mysqli_num_rows($result_direcciones) > 0) {
                    while ($direccion = mysqli_fetch_assoc($result_direcciones)) {
                        ?>
                        <div class="direccion-card <?= $direccion['es_predeterminada'] ? 'predeterminada' : '' ?>">
                            <?php if ($direccion['es_predeterminada']): ?>
                                <span class="direccion-predeterminada"><i class="fas fa-check-circle"></i> Predeterminada</span>
                            <?php endif; ?>
                            <h4><?= htmlspecialchars($direccion['nombre_receptor']) ?></h4>
                            <p><i class="fas fa-phone"></i> <?= htmlspecialchars($direccion['telefono_contacto']) ?></p>
                            <p>
                                <i class="fas fa-map-marker-alt"></i>
                                <?= htmlspecialchars($direccion['calle']) ?> #<?= htmlspecialchars($direccion['numero_exterior']) ?>
                                <?= $direccion['numero_interior'] ? ', Int. ' . htmlspecialchars($direccion['numero_interior']) : '' ?>,
                                <?= htmlspecialchars($direccion['colonia']) ?>,
                                <?= htmlspecialchars($direccion['codigo_postal']) ?>
                            </p>
                            <p><?= htmlspecialchars($direccion['ciudad']) ?>, <?= htmlspecialchars($direccion['estado']) ?></p>
                            <?php if (!empty($direccion['referencias'])): ?>
                                <p><strong>Referencias:</strong> <?= htmlspecialchars($direccion['referencias']) ?></p>
                            <?php endif; ?>
                            <div class="direccion-actions">
                                <button class="btn-edit-direccion" data-id="<?= $direccion['id'] ?>">Editar</button>
                                <button class="btn-delete-direccion" data-id="<?= $direccion['id'] ?>">Eliminar</button>
                                <?php if (!$direccion['es_predeterminada']): ?>
                                    <button class="btn-default-direccion" data-id="<?= $direccion['id'] ?>">Hacer predeterminada</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>Aún no se ha guardado ninguna dirección.</p>';
                }
                ?>
            </div>

            <button id="btn-add-direccion" class="btn-add-direccion">Agregar dirección</button>
        </div>
    </div>
</section>

<!-- Modal para agregar/editar dirección -->
<div id="direccion-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3 id="modal-title">Agregar nueva dirección</h3>

        <form id="form-direccion" method="POST" action="../../../includes/guardar_direccion.php">
            <input type="hidden" id="direccion_id" name="direccion_id" value="">

            <div class="form-group">
                <label for="nombre_receptor">Nombre del receptor*</label>
                <input type="text" id="nombre_receptor" name="nombre_receptor" required>
            </div>

            <div class="form-group">
                <label for="telefono_contacto">Teléfono de contacto*</label>
                <input type="tel" id="telefono_contacto" name="telefono_contacto" required>
            </div>

            <div class="form-group">
                <label for="calle">Calle*</label>
                <input type="text" id="calle" name="calle" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="numero_exterior">Número exterior*</label>
                    <input type="text" id="numero_exterior" name="numero_exterior" required>
                </div>

                <div class="form-group">
                    <label for="numero_interior">Número interior</label>
                    <input type="text" id="numero_interior" name="numero_interior">
                </div>
            </div>

            <div class="form-group">
                <label for="colonia">Colonia*</label>
                <input type="text" id="colonia" name="colonia" required>
            </div>

            <div class="form-group">
                <label for="codigo_postal">Código postal*</label>
                <input type="text" id="codigo_postal" name="codigo_postal" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="ciudad">Ciudad*</label>
                    <input type="text" id="ciudad" name="ciudad" required>
                </div>

                <div class="form-group">
                    <label for="estado">Estado*</label>
                    <input type="text" id="estado" name="estado" required>
                </div>
            </div>

            <div class="form-group">
                <label for="referencias">Referencias o indicaciones adicionales</label>
                <textarea id="referencias" name="referencias" rows="3"></textarea>
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="es_predeterminada" name="es_predeterminada" value="1">
                <label for="es_predeterminada">Establecer como dirección predeterminada</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Guardar dirección</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/scriptPerfil.js"></script>

</body>
</html>