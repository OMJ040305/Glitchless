<?php
session_start();

// Simular datos del usuario si existen en sesión
$nombre = $_SESSION['nombre_usuario'] ?? '';
$email = $_SESSION['email_usuario'] ?? '';

// Simulación de mensaje
$mensaje = '';
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí podrías validar los datos, guardarlos en una base de datos, enviar correo, etc.
    $exito = true;
    $mensaje = "¡Pago procesado correctamente! Gracias por tu compra.";
    // Si quieres vaciar el carrito:
    // $_SESSION['carrito'] = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar - Simulación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .btn {
            background-color: #4f46e5;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
        }

        .btn:hover {
            background-color: #4338ca;
        }

        .success {
            background: #d1e7dd;
            padding: 15px;
            border-radius: 6px;
            color: #0f5132;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Formulario de Pago</h2>

    <?php if ($exito): ?>
        <div class="success"><?php echo $mensaje; ?></div>
        <p>Redirigiendo a inicio...</p>
        <script>setTimeout(() => window.location.href = "../../index.php", 4000);</script>
    <?php else: ?>
        <form method="post">
            <div class="form-group">
                <label>Nombre del titular</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <div class="form-group">
                <label>Número de tarjeta</label>
                <input type="text" name="numero_tarjeta" maxlength="19" placeholder="1234 5678 9012 3456" required>
            </div>
            <div class="form-group">
                <label>Fecha de vencimiento</label>
                <input type="text" name="vencimiento" placeholder="MM/AA" required>
            </div>
            <div class="form-group">
                <label>CVV</label>
                <input type="text" name="cvv" maxlength="4" required>
            </div>
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="tel" name="telefono" required>
            </div>
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" required>
            </div>
            <button type="submit" class="btn">Pagar</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
