<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Glitchless Main</title>
    <link rel="stylesheet" href="assets/css/styleIndex.css">
</head>
<body>

<header class="header">
    <div class="menu container">
        <a href="#" class="logo">Glitchless</a>
        <input type="checkbox" id="menu">
        <label for="menu">
            <img src="assets/images/menu.png" class="menu-icono" alt="Menú">
        </label>
        <nav class="navbar">
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
        <div>
            <ul>
                <li class="submenu">
                    <img src="assets/images/car.svg" id="img-carrito" alt="Carrito de compras">
                    <div id="carrito">
                        <table id="lista-carrito">
                            <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <a href="#" id="vaciar-carrito" class="btn-2">Vaciar carrito</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="header-content container">
        <div class="header-img">
            <img src="assets/images/NAUT.png" alt="Promoción de lentes">
        </div>
        <div class="header-text">
            <h1>Ofertas Especiales</h1>
            <p>Estrena los mejores lentes del mercado</p>
            <a href="#" class="btn-1">Más información</a>
        </div>
    </div>
</header>

<section class="ofert container">
    <div class="ofert-1">
        <div class="ofert-img">
            <img src="assets/images/xiaomiBlueLight.png" alt="Xiaomi Blue Light Glasses">
        </div>
        <div class="ofert-text">
            <h3>Xiaomi Blue Light Blocking Glasses</h3>
            <a href="#" class="btn-2">Más información</a>
        </div>
    </div>
    <div class="ofert-1">
        <div class="ofert-img">
            <img src="assets/images/Twiins.png" alt="Gafas oftálmicas Twiins">
        </div>
        <div class="ofert-text">
            <h3>Gafas oftálmicas Twiins BP_TWHK09</h3>
            <a href="#" class="btn-2">Más información</a>
        </div>
    </div>
    <div class="ofert-1">
        <div class="ofert-img">
            <img src="assets/images/IBLU02.avif" alt="IBLU02 MM00">
        </div>
        <div class="ofert-text">
            <h3>Gafas de lectura IBLU02 MM00 Filtro luz azul neutro</h3>
            <a href="#" class="btn-2">Más información</a>
        </div>
    </div>
</section>

<main class="products container" id="lista-1">
    <h2>Productos</h2>
    <div class="products-content">

        <div class="product">
            <img src="assets/images/prod1.jpg" alt="Producto 1">
            <div class="product-txt">
                <h3>Marca</h3>
                <p>Descripción breve del producto</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="1">Agregar al carrito</a>
            </div>
        </div>

        <div class="product">
            <img src="assets/images/prod1.jpg" alt="Producto 2">
            <div class="product-txt">
                <h3>Marca</h3>
                <p>Descripción breve del producto</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="2">Agregar al carrito</a>
            </div>
        </div>

        <div class="product">
            <img src="assets/images/prod1.jpg" alt="Producto 2">
            <div class="product-txt">
                <h3>Marca</h3>
                <p>Descripción breve del producto</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="3">Agregar al carrito</a>
            </div>
        </div>

        <div class="product">
            <img src="assets/images/prod1.jpg" alt="Producto 2">
            <div class="product-txt">
                <h3>Marca</h3>
                <p>Descripción breve del producto</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="4">Agregar al carrito</a>
            </div>
        </div>

        <div class="product">
            <img src="assets/images/prod1.jpg" alt="Producto 2">
            <div class="product-txt">
                <h3>Marca</h3>
                <p>Descripción breve del producto</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="5">Agregar al carrito</a>
            </div>
        </div>

        <div class="product">
            <img src="assets/images/prod1.jpg" alt="Producto 2">
            <div class="product-txt">
                <h3>Marca</h3>
                <p>Descripción breve del producto</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="6">Agregar al carrito</a>
            </div>
        </div>

    </div>
</main>

<section class="icons container">
    <div class="icon-1">
        <div class="icon-img">
            <img src="assets/images/envio.png" alt="Icono 1">
        </div>
        <div class="icon-txt">
            <h3>Envíos rápidos</h3>
            <p>Servicio de entrega en menos de 48 horas</p>
        </div>
    </div>
    <div class="icon-1">
        <div class="icon-img">
            <img src="assets/images/garantia.png" alt="Icono 2">
        </div>
        <div class="icon-txt">
            <h3>Garantía asegurada</h3>
            <p>Todos nuestros productos cuentan con garantía</p>
        </div>
    </div>
    <div class="icon-1">
        <div class="icon-img">
            <img src="assets/images/atencion.png" alt="Icono 3">
        </div>
        <div class="icon-txt">
            <h3>Atención personalizada</h3>
            <p>Soporte 24/7 para resolver tus dudas</p>
        </div>
    </div>
</section>

<section class="blog container">
    <div class="blog-1">
        <img src="assets/images/blog1.jpg" alt="Artículo del blog 1">
        <h3>Consejos para elegir lentes</h3>
        <p>Descubre cómo escoger el modelo ideal para tu rostro.</p>
    </div>
    <div class="blog-1">
        <img src="assets/images/blog2.jpg" alt="Artículo del blog 2">
        <h3>Protección visual</h3>
        <p>Importancia de proteger tus ojos de pantallas.</p>
    </div>
    <div class="blog-1">
        <img src="assets/images/blog3.jpg" alt="Artículo del blog 3">
        <h3>Tendencias en moda óptica</h3>
        <p>Los modelos que están marcando la diferencia.</p>
    </div>
</section>

<footer class="footer">
    <div class="footer-content container">
        <div class="link">
            <h3>Información</h3>
            <ul>
                <li><a href="#">Acerca de nosotros</a></li>
                <li><a href="#">Términos y condiciones</a></li>
                <li><a href="#">Política de privacidad</a></li>
                <li><a href="#">Soporte</a></li>
            </ul>
        </div>
        <div class="link">
            <h3>Servicios</h3>
            <ul>
                <li><a href="#">Atención al cliente</a></li>
                <li><a href="#">Envíos</a></li>
                <li><a href="#">Devoluciones</a></li>
                <li><a href="#">Afiliados</a></li>
            </ul>
        </div>
        <div class="link">
            <h3>Redes sociales</h3>
            <ul>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">YouTube</a></li>
            </ul>
        </div>
    </div>
</footer>

<script src="assets/js/scriptIndex.js"></script>

</body>
</html>
