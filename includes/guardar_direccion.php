<?php
// Guardar o actualizar dirección
// Ruta: ../../../includes/guardar_direccion.php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit();
}

// Verificar si se recibieron datos por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
    exit();
}

include 'conexionBD.php';

// Obtener datos del formulario
$usuario_id = $_SESSION['usuario_id'];
$direccion_id = isset($_POST['direccion_id']) && !empty($_POST['direccion_id']) ? $_POST['direccion_id'] : null;
$nombre_receptor = $_POST['nombre_receptor'];
$telefono_contacto = $_POST['telefono_contacto'];
$calle = $_POST['calle'];
$numero_exterior = $_POST['numero_exterior'];
$numero_interior = isset($_POST['numero_interior']) ? $_POST['numero_interior'] : null;
$colonia = $_POST['colonia'];
$codigo_postal = $_POST['codigo_postal'];
$ciudad = $_POST['ciudad'];
$estado = $_POST['estado'];
$referencias = isset($_POST['referencias']) ? $_POST['referencias'] : null;
$es_predeterminada = isset($_POST['es_predeterminada']) ? 1 : 0;

// Validaciones básicas
if (empty($nombre_receptor) || empty($telefono_contacto) || empty($calle) || empty($numero_exterior) ||
    empty($colonia) || empty($codigo_postal) || empty($ciudad) || empty($estado)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados']);
    exit();
}

// Si es predeterminada, desmarcar cualquier otra dirección predeterminada del usuario
if ($es_predeterminada) {
    $query_update_default = "UPDATE direcciones SET es_predeterminada = 0 WHERE usuario_id = ?";
    $stmt_update_default = mysqli_prepare($conexion, $query_update_default);

    if ($stmt_update_default) {
        mysqli_stmt_bind_param($stmt_update_default, 'i', $usuario_id);
        mysqli_stmt_execute($stmt_update_default);
        mysqli_stmt_close($stmt_update_default);
    }
}

// Verificar si es una actualización o una nueva dirección
if ($direccion_id) {
    // Actualizar dirección existente
    $query = "UPDATE direcciones SET 
                nombre_receptor = ?, 
                telefono_contacto = ?, 
                calle = ?, 
                numero_exterior = ?, 
                numero_interior = ?, 
                colonia = ?, 
                codigo_postal = ?, 
                ciudad = ?, 
                estado = ?, 
                referencias = ?, 
                es_predeterminada = ? 
              WHERE id = ? AND usuario_id = ?";

    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssssssssssiis',
            $nombre_receptor,
            $telefono_contacto,
            $calle,
            $numero_exterior,
            $numero_interior,
            $colonia,
            $codigo_postal,
            $ciudad,
            $estado,
            $referencias,
            $es_predeterminada,
            $direccion_id,
            $usuario_id
        );
    }
} else {
    // Insertar nueva dirección
    $query = "INSERT INTO direcciones (
                usuario_id, 
                nombre_receptor, 
                telefono_contacto, 
                calle, 
                numero_exterior, 
                numero_interior, 
                colonia, 
                codigo_postal, 
                ciudad, 
                estado, 
                referencias, 
                es_predeterminada
              ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'issssssssssi',
            $usuario_id,
            $nombre_receptor,
            $telefono_contacto,
            $calle,
            $numero_exterior,
            $numero_interior,
            $colonia,
            $codigo_postal,
            $ciudad,
            $estado,
            $referencias,
            $es_predeterminada
        );
    }
}

// Ejecutar la consulta
if ($stmt) {
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($resultado) {
        // Redireccionar de vuelta al perfil
        header('Location: ../public/assets/php/perfil.php');
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error al guardar la dirección: ' . mysqli_error($conexion)]);
        exit();
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
    exit();
}
?>