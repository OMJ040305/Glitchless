<?php

SESSION_START();

if (!isset($_SESSION['correo'])) {
    echo '
        <scrript>
            alert("Debes iniciar sesion");
            window.location = "index.php";
        </scrript>
    ';
    header('Location: index.php');
    session_destroy();
    die();
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glitchless - Inicio</title>
    <link rel="stylesheet" href="assets/css/stylesEcommerce.css">
</head>
<body>
<header>
    <div class="logo-container">
        <img src="assets/images/logo.png" alt="logo">
        <div class="logo-text">Glitchless</div>
    </div>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Categorías</a>
                <ul>
                    <li><a href="#">Protección de Luz Azul</a></li>
                    <li><a href="#">Comodidad y Ergonomía</a></li>
                    <li><a href="#">Estilo y Diseño</a></li>
                    <li><a href="#">Funcionalidad</a></li>
                </ul>
            </li>
            <li><a href="#">Contacto</a></li>
            <li><a href="#">Blog</a></li>
        </ul>
    </nav>
    <div class="icons">
        <span class="user-icon">👤</span>
        <span class="cart-icon">🛒</span>
    </div>
</header>
<main>
    <section class="hero">
        <h1>Protege tu vista, mejora tu rendimiento</h1>
        <p>Descubre nuestra colección de lentes diseñados para programadores.</p>
        <div class="search-bar">
            <input type="text" placeholder="Buscar un producto...">
            <button>🔍</button>
        </div>
    </section>

    <a HREF="php/cerrar_sesion.php">Cerrar sesion</a>

</main>
</body>

</html>
