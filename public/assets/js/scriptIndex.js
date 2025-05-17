document.addEventListener('DOMContentLoaded', function () {
    // Mostrar modal genérico
    function mostrarModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'block';
    }

    // Ocultar modal genérico
    function ocultarModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'none';
    }

    // Detectar enlaces relacionados a términos
    const allLinks = document.querySelectorAll('a');
    allLinks.forEach(function (link) {
        const href = link.getAttribute('href')?.toLowerCase() || '';
        const text = link.textContent.toLowerCase();

        if (href.includes('terminos') || href.includes('términos') || text.includes('términos y condiciones')) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                mostrarModal('modal');
            });
        }
    });

    // Enlaces específicos
    const terminosLink = document.querySelector('.terminos-link');
    if (terminosLink) {
        terminosLink.addEventListener('click', function (e) {
            e.preventDefault();
            mostrarModal('modal');
        });
    }

    const privacidadLink = document.querySelector('.privacidad-link');
    if (privacidadLink) {
        privacidadLink.addEventListener('click', function (e) {
            e.preventDefault();
            mostrarModal('modal-privacidad');
        });
    }

    const acercaLink = document.querySelector('.acerca-link');
    if (acercaLink) {
        acercaLink.addEventListener('click', function (e) {
            e.preventDefault();
            mostrarModal('modal-acerca');
        });
    }

    // Cerrar modales al hacer clic fuera o en botón cerrar
    ['modal', 'modal-privacidad', 'modal-acerca'].forEach(id => {
        const modal = document.getElementById(id);
        if (!modal) return;

        const closeBtn = modal.querySelector('.modal-content span');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                ocultarModal(id);
            });
        }

        window.addEventListener('click', function (e) {
            if (e.target === modal) {
                ocultarModal(id);
            }
        });
    });

    // Menú desplegable del usuario
    const userName = document.querySelector('.user-name');
    const dropdownMenu = document.getElementById('userDropdownMenu');

    if (userName && dropdownMenu) {
        dropdownMenu.style.display = 'none';

        userName.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function (event) {
            if (!userName.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    }

    // Funcionalidad para agregar productos al carrito
    const botonesAgregarCarrito = document.querySelectorAll('.agregar-carrito');
    botonesAgregarCarrito.forEach(function(boton) {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const productoId = this.getAttribute('data-id');

            // Realizar petición AJAX para agregar al carrito
            fetch('assets/php/agregar_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'producto_id=' + productoId + '&cantidad=1'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar contador del carrito
                        const carritoCount = document.querySelector('.carrito-count');
                        if (carritoCount) {
                            carritoCount.textContent = data.total_items;
                            carritoCount.style.display = 'block';
                        } else {
                            // Si no existe el contador, crear uno
                            const imgCarrito = document.getElementById('img-carrito');
                            if (imgCarrito) {
                                const countSpan = document.createElement('span');
                                countSpan.className = 'carrito-count';
                                countSpan.textContent = data.total_items;
                                imgCarrito.parentNode.appendChild(countSpan);
                            }
                        }

                        // Mostrar mensaje de éxito
                        mostrarNotificacion('Producto agregado al carrito', 'success');
                    } else {
                        mostrarNotificacion('Error al agregar el producto', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al agregar el producto', 'error');
                });
        });
    });

    // Función para mostrar notificaciones
    function mostrarNotificacion(mensaje, tipo) {
        // Verificar si ya existe una notificación y removerla
        const notificacionAnterior = document.querySelector('.notificacion');
        if (notificacionAnterior) {
            notificacionAnterior.remove();
        }

        // Crear elemento de notificación
        const notificacion = document.createElement('div');
        notificacion.className = `notificacion ${tipo}`;
        notificacion.textContent = mensaje;

        // Agregar al DOM
        document.body.appendChild(notificacion);

        // Mostrar con animación
        setTimeout(() => {
            notificacion.style.opacity = '1';
            notificacion.style.transform = 'translateY(0)';
        }, 10);

        // Ocultar después de 3 segundos
        setTimeout(() => {
            notificacion.style.opacity = '0';
            notificacion.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                notificacion.remove();
            }, 300);
        }, 3000);
    }
});
