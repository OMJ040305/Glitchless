<?php
session_start();

// Incluir el archivo de conexión
include '../includes/conexionBD.php';

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Funciones para gestionar el carrito
function obtenerProductosPorIds($conexion, $ids)
{
    if (empty($ids)) {
        return array();
    }

    $idsString = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT * FROM productos WHERE id IN ($idsString)";

    $stmt = mysqli_prepare($conexion, $sql);
    if ($stmt) {
        $tipos = str_repeat('i', count($ids)); // 'i' para integer
        mysqli_stmt_bind_param($stmt, $tipos, ...$ids);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $productos = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $productos[$row['id']] = $row;
        }

        mysqli_stmt_close($stmt);
        return $productos;
    }

    return array();
}

function calcularTotal($productos, $cantidades)
{
    $total = 0;
    foreach ($productos as $id => $producto) {
        if (isset($cantidades[$id])) {
            $total += $producto['precio'] * $cantidades[$id];
        }
    }
    return $total;
}

// Procesar acciones del carrito
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'agregar':
            if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
                $productoId = (int)$_POST['producto_id'];
                $cantidad = (int)$_POST['cantidad'];

                if (!isset($_SESSION['carrito'][$productoId])) {
                    $_SESSION['carrito'][$productoId] = 0;
                }

                $_SESSION['carrito'][$productoId] += $cantidad;
            }
            header('Location: cart.php');
            exit;
            break;

        case 'actualizar':
            if (isset($_POST['cantidades']) && is_array($_POST['cantidades'])) {
                foreach ($_POST['cantidades'] as $id => $cantidad) {
                    $id = (int)$id;
                    $cantidad = (int)$cantidad;

                    if ($cantidad > 0) {
                        $_SESSION['carrito'][$id] = $cantidad;
                    } else {
                        unset($_SESSION['carrito'][$id]);
                    }
                }
            }
            header('Location: cart.php');
            exit;
            break;

        case 'eliminar':
            if (isset($_POST['producto_id'])) {
                $productoId = (int)$_POST['producto_id'];
                if (isset($_SESSION['carrito'][$productoId])) {
                    unset($_SESSION['carrito'][$productoId]);
                }
            }
            header('Location: cart.php');
            exit;
            break;

        case 'vaciar':
            $_SESSION['carrito'] = array();
            header('Location: cart.php');
            exit;
            break;
    }
}

// Obtener los productos del carrito
$productosIds = array_keys($_SESSION['carrito']);
$productos = obtenerProductosPorIds($conexion, $productosIds);
$total = calcularTotal($productos, $_SESSION['carrito']);

// Calcular envío
$costoEnvio = 39.00;
$totalConEnvio = $total + $costoEnvio;

// Verificar si el usuario está logueado
$usuarioLogueado = isset($_SESSION['usuario_id']);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Glitchless</title>
    <link rel="stylesheet" href="../css/styleCart.css">
</head>
<body>

<header class="header">
    <div class="menu container">
        <a href="../../index.php" class="logo">Glitchless</a>
        <input type="checkbox" id="menu">
        <label for="menu">
            <img src="../images/menu.png" class="menu-icono" alt="Menú">
        </label>
        <nav class="navbar">
            <ul>
                <li><a href="../../index.php">Inicio</a></li>
                <li><a href="../../index.php#productos">Productos</a></li>
                <li><a href="../../index.php#blog">Blog</a></li>
                <li><a href="../../index.php#contacto">Contacto</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <ul>
                <li class="submenu">
                    <?php if (isset($_SESSION['nombre_usuario'])): ?>
                        <span class="user-name">
                            <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>
                        </span>
                        <ul class="dropdown-menu" id="userDropdownMenu">
                            <li><a href="../php/perfil.php">Perfil</a></li>
                            <li><a href="../../../includes/cerrar_sesion.php">Cerrar sesión</a></li>
                        </ul>
                    <?php else: ?>
                        <a href="../php/login.php">
                            <img src="../images/usericon.png" alt="Iniciar Sesión">
                        </a>
                    <?php endif; ?>
                </li>
                <li class="submenu carrito-icon">
                    <a href="cart.php" class="carrito-active">
                        <img src="../images/car.svg" id="img-carrito" alt="Carrito de compras">
                        <?php if (count($_SESSION['carrito']) > 0): ?>
                            <span class="carrito-count"><?php echo array_sum($_SESSION['carrito']); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<main class="cart-container container">
    <div class="cart-content">
        <div class="cart-left">
            <?php if (!empty($productos)): ?>
                <div class="cart-header">
                    <h2>Carrito de compras</h2>
                    <form method="post" action="cart.php">
                        <input type="hidden" name="action" value="vaciar">
                        <button type="submit" class="btn-vaciar">Vaciar carrito</button>
                    </form>
                </div>

                <div class="cart-seller">
                    <div class="seller-info">
                        <span class="seller-name">Productos de GLITCHLESS</span>
                    </div>

                    <div class="cart-items">
                        <?php foreach ($productos as $id => $producto): ?>
                            <div class="cart-item">
                                <div class="item-checkbox">
                                    <input type="checkbox" checked disabled>
                                </div>
                                <div class="item-image">
                                    <img src="<?php echo !empty($producto['imagen']) ? 'assets/images/' . $producto['imagen'] : 'assets/images/no-image.png'; ?>"
                                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                </div>
                                <div class="item-details">
                                    <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                                    <p class="item-description"><?php echo htmlspecialchars(substr($producto['descripcion'], 0, 100)); ?>
                                        ...</p>

                                    <div class="item-actions">
                                        <form method="post" action="cart.php" class="inline-form">
                                            <input type="hidden" name="action" value="eliminar">
                                            <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                            <button type="submit" class="btn-eliminar">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="item-quantity">
                                    <div class="quantity-selector">
                                        <form method="post" action="cart.php" class="quantity-form">
                                            <input type="hidden" name="action" value="actualizar">
                                            <button type="button" class="quantity-btn minus"
                                                    data-id="<?php echo $id; ?>">-
                                            </button>
                                            <input type="number" name="cantidades[<?php echo $id; ?>]"
                                                   value="<?php echo $_SESSION['carrito'][$id]; ?>" min="1" max="10"
                                                   class="quantity-input" data-id="<?php echo $id; ?>">
                                            <button type="button" class="quantity-btn plus"
                                                    data-id="<?php echo $id; ?>">+
                                            </button>
                                            <button type="submit" class="update-btn">Actualizar</button>
                                        </form>
                                    </div>
                                    <div class="availability">
                                        <span>Disponible: <?php echo $producto['stock']; ?></span>
                                    </div>
                                </div>
                                <div class="item-price">
                                    <span class="price">$<?php echo number_format($producto['precio'], 2); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="cart-shipping">
                    <div class="shipping-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <h3>Envío</h3>
                    </div>
                    <div class="shipping-info">
                        <p>Envío a domicilio</p>
                        <span class="shipping-price">$<?php echo number_format($costoEnvio, 2); ?></span>
                    </div>
                </div>

            <?php else: ?>
                <div class="empty-cart">
                    <img src="../images/car.svg" alt="Carrito vacío">
                    <h2>Tu carrito está vacío</h2>
                    <p>¿No sabes qué comprar? ¡Checa nuestras ofertas!</p>
                    <a href="../../index.php#productos" class="btn-2">Ver productos</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="cart-right">
            <div class="summary-container">
                <div class="summary-header">
                    <h3>Resumen de compra</h3>
                </div>
                <div class="summary-content">
                    <div class="summary-row">
                        <span>Productos (<?php echo array_sum($_SESSION['carrito']); ?>)</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Envío</span>
                        <span>$<?php echo number_format($costoEnvio, 2); ?></span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span class="total-price">$<?php echo number_format($totalConEnvio, 2); ?></span>
                    </div>
                    <!-- El botón siempre estará visible, sin importar el estado del carrito -->
                    <div class="summary-buttons">
                        <a href="checkout.php" class="btn-checkout btn-stripe">Pagar ahora</a>
                        <a href="../../index.php#productos" class="btn-continue-shopping">Seguir comprando</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Manejar botones de cantidad
        const minusBtns = document.querySelectorAll('.quantity-btn.minus');
        const plusBtns = document.querySelectorAll('.quantity-btn.plus');

        minusBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            });
        });

        plusBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                const max = parseInt(input.getAttribute('max'));
                const currentValue = parseInt(input.value);
                if (currentValue < max) {
                    input.value = currentValue + 1;
                }
            });
        });

        // Mostrar el menú desplegable de usuario al hacer clic en el nombre
        const userName = document.querySelector('.user-name');
        const userMenu = document.getElementById('userDropdownMenu');

        if (userName && userMenu) {
            userName.addEventListener('click', function (e) {
                e.preventDefault();
                userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
            });

            // Cerrar el menú al hacer clic fuera de él
            document.addEventListener('click', function (e) {
                if (!userName.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.style.display = 'none';
                }
            });
        }
    });
</script>

</body>
</html>
