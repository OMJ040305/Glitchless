<?php
// Establecer una dirección como predeterminada
// Ruta: ../../../includes/predeterminar_direccion.php

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

// Primero, desmarcar todas las direcciones del usuario como predeterminadas
$query_update = "UPDATE direcciones SET es_predeterminada = 0 WHERE usuario_id = ?";
$stmt_update = mysqli_prepare($conexion, $query_update);

if ($stmt_update) {
    mysqli_stmt_bind_param($stmt_update, 'i', $usuario_id);
    mysqli_stmt_execute($stmt_update);
    mysqli_stmt_close($stmt_update);

    // Ahora, marcar la dirección seleccionada como predeterminada
    $query_set = "UPDATE direcciones SET es_predeterminada = 1 WHERE id = ? AND usuario_id = ?";
    $stmt_set = mysqli_prepare($conexion, $query_set);

    if ($stmt_set) {
        mysqli_stmt_bind_param($stmt_set, 'ii', $direccion_id, $usuario_id);
        $resultado = mysqli_stmt_execute($stmt_set);

        if ($resultado) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Dirección establecida como predeterminada']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al establecer como predeterminada: ' . mysqli_error($conexion)]);
        }

        mysqli_stmt_close($stmt_set);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
}
?>