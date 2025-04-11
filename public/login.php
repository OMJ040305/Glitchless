<?php

session_start();

if (isset($_SESSION['correo'])) {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso a la plataforma</title>
    <link rel="stylesheet" href="assets/css/styleLogin.css">

</head>
<body>

<main>
    <div class="contenedor__todo">
        <div class="caja__trasera">
            <div class="caja__trasera-login">
                <h3>¿Ya estás registrado?</h3>
                <p>Accede a tu cuenta para continuar</p>
                <button id="btn__iniciar-sesion">Iniciar sesión</button>
            </div>
            <div class="caja__trasera-registro">
                <h3>¿Aún no tienes una cuenta?</h3>
                <p>Crea una cuenta para acceder a la plataforma</p>
                <button id="btn__registrate">Crear cuenta</button>
            </div>
        </div>

        <!-- Formularios de acceso y registro -->
        <div class="contenedor__login-registro">
            <form action="../includes/login_usuarioBD.php" method="post" class="formulario__login">
                <h2>Acceso</h2>
                <input type="text" placeholder="Correo electrónico" name="correo">
                <input type="password" placeholder="Contraseña" name="contrasena">
                <button>Iniciar sesión</button>
            </form>

            <!--Registro-->
            <form action="../includes/registro_usuarioBD.php" method="post" class="formulario__registro">
                <h2>Registro</h2>
                <input type="text" placeholder="Nombre completo" name="nombre_completo">
                <input type="text" placeholder="Correo electrónico" name="correo">
                <input type="text" placeholder="Nombre de usuario" name="usuario">
                <input type="password" placeholder="Contraseña" name="contrasena">
                <button>Crear cuenta</button>
            </form>
        </div>
    </div>
</main>

<script src="assets/js/scriptLogin.js"></script>

</body>
</html>
