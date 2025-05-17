<?php
// Este archivo permite eliminar un producto del carrito mediante AJAX
session_start();

// Inicializar respuesta
$response = array(
    'success' => false,
    'message' => '',
    'total_items' => 0
);

// Verificar si se recibió una solicitud POST con el ID del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $productoId = (int)$_POST['producto_id'];

    // Verificar si el carrito existe y el producto está en él
    if (isset($_SESSION['carrito']) && isset($_SESSION['carrito'][$productoId])) {
        // Eliminar el producto del carrito
        unset($_SESSION['carrito'][$productoId]);

        $response['success'] = true;
        $response['message'] = 'Producto eliminado del carrito';
    } else {
        $response['message'] = 'El producto no está en el carrito';
    }
} else {
    $response['message'] = 'Solicitud inválida';
}

// Calcular total de items en el carrito
if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    $response['total_items'] = array_sum($_SESSION['carrito']);
}

// Devolver respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>