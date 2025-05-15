<?php

SESSION_START();

include 'conexionBD.php';

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Desencriptacion de la contrasena
$contrasena = hash('sha512', $contrasena);

$validar_login = mysqli_query($conexion,
    "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasena = '$contrasena'");

if (mysqli_num_rows($validar_login) > 0) {
    $usuario = mysqli_fetch_assoc($validar_login); // Obtener datos del usuario

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nombre_usuario'] = $usuario['nombre_completo']; // Guarda el nombre del usuario

    header("location:../public/index.php");
    exit();
} else {
    echo '<script>
            alert("usuario no existe, porfavor intente de nuevo");
            window.location = "../public/assets/php/login.php";
          </script>';
    exit();
}
