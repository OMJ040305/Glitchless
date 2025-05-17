<?php
session_start();

// Incluir archivo de conexión a la base de datos
include 'conexionBD.php';

// Inicializar respuesta
$response = array(
    'success' => false,
    'message' => '',
    'total_items' => 0
);

// Verificar si se recibió una solicitud POST con el ID del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $productoId = (int)$_POST['producto_id'];
    $cantidad = (int)$_POST['cantidad'];

    // Validar cantidad
    if ($cantidad <= 0) {
        $cantidad = 1;
    }

    // Inicializar carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    // Verificar si el producto existe en la base de datos
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $productoId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($producto = mysqli_fetch_assoc($result)) {
            // Verificar stock
            if ($producto['stock'] > 0) {
                // Verificar si el producto ya está en el carrito
                if (isset($_SESSION['carrito'][$productoId])) {
                    // Sumar la cantidad asegurando que no exceda el stock
                    $nuevaCantidad = $_SESSION['carrito'][$productoId] + $cantidad;
                    $_SESSION['carrito'][$productoId] = min($nuevaCantidad, $producto['stock']);
                } else {
                    // Agregar el producto al carrito
                    $_SESSION['carrito'][$productoId] = min($cantidad, $producto['stock']);
                }

                $response['success'] = true;
                $response['message'] = 'Producto agregado al carrito';
            } else {
                $response['message'] = 'El producto no tiene stock disponible';
            }
        } else {
            $response['message'] = 'El producto no existe';
        }

        mysqli_stmt_close($stmt);
    } else {
        $response['message'] = 'Error al procesar la solicitud';
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