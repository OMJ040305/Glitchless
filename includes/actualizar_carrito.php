<?php
// Este archivo permite actualizar la cantidad de un producto en el carrito mediante AJAX
session_start();

// Incluir archivo de conexión a la base de datos
include 'conexionBD.php';

// Inicializar respuesta
$response = array(
    'success' => false,
    'message' => '',
    'total_items' => 0,
    'subtotal' => 0,
    'total' => 0
);

// Verificar si se recibió una solicitud POST con el ID del producto y la cantidad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $productoId = (int)$_POST['producto_id'];
    $cantidad = (int)$_POST['cantidad'];

    // Validar cantidad
    if ($cantidad <= 0) {
        // Si la cantidad es 0 o menor, eliminar el producto del carrito
        if (isset($_SESSION['carrito'][$productoId])) {
            unset($_SESSION['carrito'][$productoId]);
            $response['success'] = true;
            $response['message'] = 'Producto eliminado del carrito';
        }
    } else {
        // Verificar si el producto existe en la base de datos y tiene suficiente stock
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $productoId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($producto = mysqli_fetch_assoc($result)) {
                // Verificar stock
                if ($producto['stock'] >= $cantidad) {
                    // Actualizar la cantidad en el carrito
                    $_SESSION['carrito'][$productoId] = $cantidad;

                    $response['success'] = true;
                    $response['message'] = 'Cantidad actualizada';
                    $response['subtotal'] = $producto['precio'] * $cantidad;
                } else {
                    // Si no hay suficiente stock, limitar a lo disponible
                    $_SESSION['carrito'][$productoId] = $producto['stock'];

                    $response['success'] = true;
                    $response['message'] = 'Cantidad limitada por stock disponible';
                    $response['subtotal'] = $producto['precio'] * $producto['stock'];
                }
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Calcular el total del carrito
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        // Obtener los IDs de los productos en el carrito
        $productoIds = array_keys($_SESSION['carrito']);

        if (!empty($productoIds)) {
            // Crear marcadores de posición para la consulta SQL
            $placeholders = implode(',', array_fill(0, count($productoIds), '?'));

            // Consulta para obtener los precios de los productos
            $sql = "SELECT id, precio FROM productos WHERE id IN ($placeholders)";
            $stmt = mysqli_prepare($conexion, $sql);

            if ($stmt) {
                // Crear un array con los tipos de parámetros (todos son enteros)
                $tipos = str_repeat('i', count($productoIds));

                // Vincular los parámetros
                mysqli_stmt_bind_param($stmt, $tipos, ...$productoIds);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $total = 0;
                while ($producto = mysqli_fetch_assoc($result)) {
                    $id = $producto['id'];
                    $precio = $producto['precio'];
                    $cantidad = $_SESSION['carrito'][$id];

                    $total += $precio * $cantidad;
                }

                $response['total'] = $total;
                mysqli_stmt_close($stmt);
            }
        }
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

