<?php
// Obtener datos de una dirección específica
// Ruta: ../../../includes/obtener_direccion.php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit();
}

// Verificar si se recibió el ID de dirección
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ID de dirección no proporcionado']);
    exit();
}

include 'conexionBD.php';

$direccion_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Consulta para obtener la dirección específica del usuario
$query = "SELECT * FROM direcciones WHERE id = ? AND usuario_id = ?";
$stmt = mysqli_prepare($conexion, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ii', $direccion_id, $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($direccion = mysqli_fetch_assoc($result)) {
        // Devolver los datos de la dirección en formato JSON
        header('Content-Type: application/json');
        echo json_encode($direccion);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Dirección no encontrada']);
    }

    mysqli_stmt_close($stmt);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
}
?>