<?php

SESSION_START();

include 'conexionBD.php';

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Desencriptacion de la contrasena
$contrasena =hash('sha512', $contrasena);

$validar_login = mysqli_query($conexion,
    "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasena = '$contrasena'");

if (mysqli_num_rows($validar_login) > 0) {
    $_SESSION['correo'] = $correo;
    header("location:../ecommerce.php");
    exit();
} else {
    echo '<script>
            alert("usuario no existe, porfavor intente de nuevo");
            window.location = "../public/index.php";
          </script>';
    exit();
}