<?php
// Eliminar una dirección
// Ruta: ../../../includes/eliminar_direccion.php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit();
}

// Verificar si se recibieron datos por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['direccion_id']) || empty($_POST['direccion_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
    exit();
}

include 'conexionBD.php';

$direccion_id = $_POST['direccion_id'];
$usuario_id = $_SESSION['usuario_id'];

// Eliminar la dirección solo si pertenece al usuario actual
$query = "DELETE FROM direcciones WHERE id = ? AND usuario_id = ?";
$stmt = mysqli_prepare($conexion, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ii', $direccion_id, $usuario_id);
    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Dirección eliminada correctamente']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error al eliminar la dirección: ' . mysqli_error($conexion)]);
    }

    mysqli_stmt_close($stmt);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
}
?>