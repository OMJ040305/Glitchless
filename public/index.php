<?php
session_start();
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Glitchless Main</title>
    <link rel="stylesheet" href="assets/css/styleIndex.css">
    <link rel="stylesheet" href="assets/css/styleModal.css">
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
                <li><a href="#top">Inicio</a></li>
                <li><a href="#productos">Productos</a></li>
                <li><a href="#blog">Blog</a></li>
                <li><a href="#contacto">Contacto</a></li>
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
                            <li><a href="assets/php/perfil.php">Perfil</a></li>
                            <li><a href="../includes/cerrar_sesion.php">Cerrar sesión</a></li>
                        </ul>
                    <?php else: ?>
                        <a href="assets/php/login.php">
                            <img src="assets/images/usericon.png" alt="Iniciar Sesión">
                        </a>
                    <?php endif; ?>
                </li>
                <li class="submenu">
                    <a href="cart.html">
                        <img src="assets/images/car.svg" id="img-carrito" alt="Carrito de compras">
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="header-content container" id="top">
        <div class="header-img">
            <img src="assets/images/NAUT.png" alt="Promoción de lentes">
        </div>
        <div class="header-text">
            <h1>Ofertas Especiales</h1>
            <p>Estrena los mejores lentes del mercado</p>
            <a href="#productos" class="btn-1">Más información</a>
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

<main class="products container" id="productos">
    <h2>Productos</h2>
    <div class="products-content">

        <div class="product">
            <img src="assets/images/Eyepetizer.png" alt="Producto 1">
            <div class="product-txt">
                <h3>Eyepetizer</h3>
                <p>Lentes De Sol Oxford-Dorado-FARFETCH CO</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="1">Agregar al carrito</a>
            </div>
        </div>

        <div class="product">
            <img src="assets/images/Marina.png" alt="Producto 2">
            <div class="product-txt">
                <h3>Marina Eyewear</h3>
                <p>Lente con protección blue cut Marina Eyewear PG2043C3 Rosa transparente</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="2">Agregar al carrito</a>
            </div>
        </div>

        <div class="product">
            <img src="assets/images/Cartier.png" alt="Producto 3">
            <div class="product-txt">
                <h3>Cartier</h3>
                <p>Lentes Cartier De Gota</p>
                <p class="precio">$999.00</p>
                <a href="#" class="agregar-carrito btn-2" data-id="3">Agregar al carrito</a>
            </div>
        </div>
    </div>
</main>

<section class="icons container">
    <div class="icon-1">
        <div class="icon-img">
            <img src="assets/images/envio.png" alt="Envíos rápidos">
        </div>
        <div class="icon-txt">
            <h3>Envíos rápidos</h3>
            <p>Servicio de entrega en menos de 48 horas para tu comodidad.</p>
        </div>
    </div>

    <div class="icon-1">
        <div class="icon-img">
            <img src="assets/images/garantia.png" alt="Garantía asegurada">
        </div>
        <div class="icon-txt">
            <h3>Garantía asegurada</h3>
            <p>Todos nuestros productos cuentan con garantía extendida y respaldo total.</p>
        </div>
    </div>

    <div class="icon-1">
        <div class="icon-img">
            <img src="assets/images/atencion.png" alt="Atención personalizada">
        </div>
        <div class="icon-txt">
            <h3>Atención personalizada</h3>
            <p>Soporte 24/7 para resolver tus dudas y brindarte la mejor experiencia.</p>
        </div>
    </div>
</section>

<section class="blog container" id="blog">
    <h2>Nuestro Blog</h2>
    <div class="blog-content">
        <div class="blog-1">
            <img src="assets/images/blog1.png" alt="Artículo del blog 1">
            <div class="blog-text">
                <h3>¿Cómo elegir los lentes perfectos?</h3>
                <p>Te compartimos tips prácticos para encontrar el estilo que realce tus facciones y personalidad.</p>
                <a href="assets/html/blog1.html" class="read-more" target="_blank">Leer más</a>
            </div>
        </div>

        <div class="blog-1">
            <img src="assets/images/blog2.png" alt="Artículo del blog 2">
            <div class="blog-text">
                <h3>Cuida tu vista en la era digital</h3>
                <p>Descubre por qué el uso de lentes con filtro azul es clave para proteger tus ojos frente a las
                    pantallas.</p>
                <a href="assets/html/blog2.html" class="read-more" target="_blank">Leer más</a>
            </div>
        </div>

        <div class="blog-1">
            <img src="assets/images/blog3.png" alt="Artículo del blog 3">
            <div class="blog-text">
                <h3>Lo último en moda óptica</h3>
                <p>Conoce las tendencias que están revolucionando el mundo de los lentes y cómo incorporarlas a tu
                    look.</p>
                <a href="assets/html/blog3.html" class="read-more" target="_blank">Leer más</a>
            </div>
        </div>
    </div>
</section>

<section id="contacto" class="contacto container">
    <h2>Contacto</h2>
    <div class="contacto-content">
        <form action="https://formsubmit.co/glitchlessmexico@gmail.com" method="POST" class="contacto-form">
            <input type="text" placeholder="Nombre" name="name">
            <input type="email" placeholder="Email" name="email">
            <textarea placeholder="Mensaje" name="comments"></textarea>
            <input type="hidden" name="_next"
                   value="http://localhost:63342/Glitchless/public/index.php?_ijt=unehfam5jbt2p2p83frlmvjstk&_ij_reload=RELOAD_ON_SAVE">
            <input type="hidden" name="_captcha" value="false">
            <button type="submit" class="btn-1">Enviar</button>
        </form>
        <div class="contacto-info">
            <p><strong>Dirección:</strong> Av. Ejemplo #123, Ciudad</p>
            <p><strong>Teléfono:</strong> (123) 456-7890</p>
            <p><strong>Email:</strong> glitchlessmexico@gmail.com</p>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer-content container">
        <div class="link">
            <h3>Información</h3>
            <ul>
                <li><a href="#" class="acerca-link">Acerca de nosotros</a></li>
                <li><a href="#" class="terminos-link">Términos y condiciones</a></li>
                <li><a href="#" class="privacidad-link">Política de privacidad</a></li>
            </ul>
        </div>
        <div class="link">
            <h3>Redes sociales</h3>
            <ul>
                <li><a href="https://www.facebook.com/profile.php?id=61575848463091" target="_blank">Facebook</a></li>
                <li><a href="https://www.instagram.com/glitchless.mex/" target="_blank">Instagram</a></li>
            </ul>
        </div>
    </div>
</footer>

<!-- Modal Términos y Condiciones de Glitchless -->
<div id="modal" class="modal"
     style="display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); overflow-y:auto;">
    <div class="modal-content"
         style="background:#fff; margin:5% auto; padding:2rem; border-radius:8px; width:90%; max-width:800px; max-height:90%; overflow-y:auto; position:relative;">
    <span onclick="document.getElementById('modal').style.display='none'"
          style="position:absolute; top:10px; right:20px; font-size:24px; cursor:pointer;">&times;</span>

        <h2>Términos y Condiciones de Glitchless</h2>
        <p><strong>Última actualización:</strong> 1 de mayo de 2025</p>

        <p>Bienvenido/a a <strong>Glitchless</strong>. Al acceder y utilizar nuestro sitio web
            <a href="http://www.glitchless.com" target="_blank">www.glitchless.com</a>, aceptas cumplir y estar sujeto a
            los siguientes términos y condiciones.
            Si no estás de acuerdo con alguno de estos términos, por favor no utilices este sitio.</p>

        <h3>1. Información General</h3>
        <p>Glitchless es una tienda en línea especializada en la venta de gafas con filtro de luz azul, diseñadas para
            programadores, desarrolladores y profesionales del entorno digital. Nos enfocamos en ofrecer productos que
            combinan salud visual, estilo y funcionalidad.</p>

        <h3>2. Uso del Sitio</h3>
        <ul>
            <li>Debes tener al menos 18 años o contar con autorización de tus padres o tutores para realizar compras en
                nuestro sitio.
            </li>
            <li>Aceptas utilizar el sitio web solo con fines legales y conforme a estos términos.</li>
        </ul>

        <h3>3. Productos y Descripciones</h3>
        <p>
            - Hacemos todo lo posible por mostrar con precisión las características de nuestros productos, pero pueden
            existir pequeñas variaciones de color, forma o materiales debido a la configuración de pantalla o a
            proveedores.<br>
            - Nos reservamos el derecho de modificar o descontinuar productos sin previo aviso.
        </p>

        <h3>4. Precios y Pagos</h3>
        <p>
            - Todos los precios están expresados en <strong>pesos mexicanos (MXN)</strong> e incluyen impuestos
            aplicables, salvo que se indique lo contrario.<br>
            - Aceptamos pagos únicamente a través de <strong>Mercado Pago</strong>, una plataforma segura que permite
            pagar con tarjetas, transferencias o saldo en cuenta.<br>
            - En caso de error en el precio de un producto, nos reservamos el derecho de cancelar el pedido y reembolsar
            el monto pagado.
        </p>

        <h3>5. Envíos y Entregas</h3>
        <p>
            - Realizamos envíos únicamente dentro de la <strong>República Mexicana</strong> mediante servicios
            logísticos certificados.<br>
            - Los plazos de entrega son estimados y pueden variar según la ubicación.<br>
            - No nos responsabilizamos por retrasos causados por terceros, desastres naturales o problemas fuera de
            nuestro control.
        </p>

        <h3>6. Cambios y Devoluciones</h3>
        <p>
            - Aceptamos devoluciones dentro de los 15 días posteriores a la recepción del pedido, siempre que el
            producto esté en su estado original y sin uso.<br>
            - Los gastos de envío por devoluciones corren por cuenta del cliente, salvo en caso de producto defectuoso o
            error por parte de Glitchless.<br>
            - Para iniciar un proceso de devolución, contáctanos a <a href="mailto:soporte@glitchless.com">soporte@glitchless.com</a>.
        </p>

        <h3>7. Propiedad Intelectual</h3>
        <p>
            - Todo el contenido del sitio, incluyendo textos, logotipos, imágenes, diseño y código, es propiedad de
            Glitchless o de sus proveedores, y está protegido por las leyes de propiedad intelectual.<br>
            - Queda prohibida su reproducción total o parcial sin autorización escrita.
        </p>

        <h3>8. Protección de Datos</h3>
        <p>Tu privacidad es importante para nosotros. Consulta nuestra Política de Privacidad para conocer cómo
            recopilamos, usamos y protegemos tu información personal.</p>

        <h3>9. Limitación de Responsabilidad</h3>
        <p>
            - Glitchless no será responsable por daños directos, indirectos o incidentales derivados del uso o la
            imposibilidad de uso del sitio web o de los productos adquiridos.<br>
            - Las gafas con filtro azul no sustituyen el consejo médico profesional. En caso de molestias visuales,
            consulta con un especialista.
        </p>

        <h3>10. Modificaciones</h3>
        <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones entrarán en
            vigor una vez publicadas en el sitio web.</p>

        <h3>11. Contacto</h3>
        <p>
            Para cualquier consulta, queja o solicitud relacionada con estos Términos y Condiciones, por favor
            contáctanos:<br>
            📧 <strong>Correo electrónico:</strong> <a
                    href="mailto:soporte@glitchless.com">soporte@glitchless.com</a><br>
            🌐 <strong>Sitio web:</strong> <a href="http://www.glitchless.com" target="_blank">www.glitchless.com</a>
        </p>
    </div>
</div>

<!-- Modal Política de Privacidad de Glitchless -->
<div id="modal-privacidad" class="modal"
     style="display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); overflow-y:auto;">
    <div class="modal-content"
         style="background:#fff; margin:5% auto; padding:2rem; border-radius:8px; width:90%; max-width:800px; max-height:90%; overflow-y:auto; position:relative;">
        <span onclick="document.getElementById('modal-privacidad').style.display='none'"
              style="position:absolute; top:10px; right:20px; font-size:24px; cursor:pointer;">&times;</span>

        <h2>Política de Privacidad de Glitchless</h2>
        <p><strong>Última actualización:</strong> 1 de mayo de 2025</p>

        <p>En <strong>Glitchless</strong>, valoramos tu privacidad y nos comprometemos a proteger tus datos personales.
            Esta Política de Privacidad describe cómo recopilamos, usamos y protegemos tu información cuando visitas
            nuestro sitio web <a href="http://www.glitchless.com" target="_blank">www.glitchless.com</a>.</p>

        <h3>1. Información que recopilamos</h3>
        <ul>
            <li>Datos de contacto: nombre, correo electrónico, dirección y teléfono.</li>
            <li>Información de pago: datos proporcionados a través de plataformas de terceros como Mercado Pago.</li>
            <li>Información técnica: dirección IP, tipo de navegador, dispositivo, y actividad en el sitio web.</li>
        </ul>

        <h3>2. Uso de la información</h3>
        <p>Utilizamos la información recopilada para:</p>
        <ul>
            <li>Procesar pedidos y pagos.</li>
            <li>Proporcionar soporte y atención al cliente.</li>
            <li>Mejorar nuestro sitio web y servicios.</li>
            <li>Enviar información promocional (con tu consentimiento).</li>
        </ul>

        <h3>3. Protección de datos</h3>
        <p>Implementamos medidas de seguridad físicas, electrónicas y administrativas para proteger tu información
            personal contra accesos no autorizados, pérdida o alteración.</p>

        <h3>4. Compartir información</h3>
        <p>No vendemos ni compartimos tus datos personales con terceros, excepto en los siguientes casos:</p>
        <ul>
            <li>Proveedores de servicios que ayudan en la operación del sitio (como servicios de pago o envío).</li>
            <li>Autoridades cuando sea requerido por ley.</li>
        </ul>

        <h3>5. Derechos del usuario</h3>
        <p>Puedes acceder, modificar o eliminar tus datos personales contactándonos a <a
                    href="mailto:soporte@glitchless.com">soporte@glitchless.com</a>.</p>

        <h3>6. Cookies</h3>
        <p>Utilizamos cookies para mejorar tu experiencia de navegación. Puedes configurar tu navegador para rechazarlas
            o eliminarlas en cualquier momento.</p>

        <h3>7. Cambios a esta política</h3>
        <p>Nos reservamos el derecho de modificar esta Política de Privacidad en cualquier momento. Los cambios serán
            efectivos desde su publicación en el sitio web.</p>

        <h3>8. Contacto</h3>
        <p>Para cualquier pregunta o solicitud relacionada con esta política, contáctanos:</p>
        <ul>
            <li>📧 Correo electrónico: <a href="mailto:soporte@glitchless.com">soporte@glitchless.com</a></li>
            <li>🌐 Sitio web: <a href="http://www.glitchless.com" target="_blank">www.glitchless.com</a></li>
        </ul>
    </div>
</div>

<!-- Modal Acerca de Nosotros de Glitchless -->
<div id="modal-acerca" class="modal"
     style="display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); overflow-y:auto;">
    <div class="modal-content"
         style="background:#fff; margin:5% auto; padding:2rem; border-radius:8px; width:90%; max-width:800px; max-height:90%; overflow-y:auto; position:relative;">
        <span onclick="document.getElementById('modal-nosotros').style.display='none'"
              style="position:absolute; top:10px; right:20px; font-size:24px; cursor:pointer;">&times;</span>

        <h2>Acerca de Glitchless</h2>
        <p><strong>Pasión por la visión digital</strong></p>

        <p>Glitchless nace con una misión clara: proteger la salud visual de quienes pasan horas frente a pantallas.
            Somos una tienda 100% mexicana especializada en lentes con filtro de luz azul, pensados especialmente para
            programadores, diseñadores, gamers y todos los que viven en el mundo digital.</p>

        <h3>¿Por qué elegirnos?</h3>
        <ul>
            <li>Ofrecemos productos de alta calidad con diseños modernos y funcionales.</li>
            <li>Trabajamos exclusivamente con marcas confiables y materiales certificados.</li>
            <li>Brindamos atención personalizada, rápida y profesional.</li>
            <li>Creemos en el comercio justo y la experiencia del cliente como prioridad.</li>
        </ul>

        <h3>Visión</h3>
        <p>Convertirnos en la tienda líder en salud visual digital en México, promoviendo el uso responsable de
            pantallas y el cuidado ocular.</p>

        <h3>Misión</h3>
        <p>Brindar soluciones accesibles y efectivas para mejorar la calidad visual de nuestros clientes, acompañándolos
            en su día a día tecnológico.</p>

        <h3>Contáctanos</h3>
        <p>¿Tienes dudas o sugerencias? Escríbenos a <a
                    href="mailto:contacto@glitchless.com">contacto@glitchless.com</a>. ¡Nos encantará saber de ti!</p>
    </div>
</div>


<script src="assets/js/scriptIndex.js"></script>

</body>
</html>
