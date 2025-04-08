<?php

include 'conexionBD.php';

$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Encriptacion de la contrasena
$contrasena =hash('sha512', $contrasena);

$query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contrasena) 
          VALUES ('$nombre_completo', '$correo', '$usuario', '$contrasena')";

// El campo correo es tipo UNIQUE en la BD
$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo'");

if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
    <script>
    alert("El correo electrónico proporcionado ya está registrado. Por favor, utiliza otro correo.");
    window.location = "../index.php";
    </script>
    ';
    exit();
}

// El campo usuario es tipo UNIQUE en la BD
$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario'");

if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
    <script>
    alert("El nombre de usuario ya se encuentra en uso. Intenta con otro nombre de usuario.");
    window.location = "../index.php";
    </script>
    ';
    exit();
}

$result = mysqli_query($conexion, $query);

if ($result) {
    echo '
    <script>
        alert("Tu cuenta ha sido creada exitosamente. Bienvenido/a a nuestra plataforma.");
        window.location = "../index.php";
    </script>
    ';
} else {
    echo '
    <script>
    alert("Hubo un problema al procesar tu solicitud. Por favor, intenta nuevamente más tarde.")
    window.location = "../index.php";
    </script>
    ';
}

mysqli_close($conexion);
