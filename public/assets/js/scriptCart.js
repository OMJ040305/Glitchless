document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad para los botones de cantidad
    const minusBtns = document.querySelectorAll('.quantity-btn.minus');
    const plusBtns = document.querySelectorAll('.quantity-btn.plus');
    const quantityInputs = document.querySelectorAll('.quantity-input');

    minusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
                actualizarCantidadAjax(id, value - 1);
            }
        });
    });

    plusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
            let value = parseInt(input.value);
            const max = parseInt(input.getAttribute('max'));
            if (value < max) {
                input.value = value + 1;
                actualizarCantidadAjax(id, value + 1);
            }
        });
    });

    // Función para actualizar cantidad mediante AJAX
    function actualizarCantidadAjax(productoId, cantidad) {
        fetch('actualizar_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `producto_id=${productoId}&cantidad=${cantidad}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar subtotal del ítem
                    const itemPriceElement = document.querySelector(`.cart-item[data-id="${productoId}"] .item-price .price`);
                    if (itemPriceElement) {
                        itemPriceElement.textContent = `$${formatNumber(data.subtotal)}`;
                    }

                    // Actualizar total del carrito
                    const totalElement = document.querySelector('.total-price');
                    if (totalElement && data.total) {
                        totalElement.textContent = `$${formatNumber(data.total + 39.00)}`; // Sumamos el costo de envío
                    }

                    // Actualizar subtotal en el resumen
                    const subtotalElement = document.querySelector('.summary-row:first-child span:last-child');
                    if (subtotalElement && data.total) {
                        subtotalElement.textContent = `$${formatNumber(data.total)}`;
                    }

                    // Actualizar contador del carrito
                    const cartCount = document.querySelector('.carrito-count');
                    if (cartCount) {
                        cartCount.textContent = data.total_items;
                    }

                    // Si la cantidad es 0, ocultar el ítem (opcional)
                    if (cantidad === 0) {
                        const cartItem = document.querySelector(`.cart-item[data-id="${productoId}"]`);
                        if (cartItem) {
                            cartItem.style.display = 'none';
                        }
                    }

                    // Mostrar notificación
                    mostrarNotificacion('Carrito actualizado', 'success');
                } else {
                    mostrarNotificacion(data.message || 'Error al actualizar el carrito', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al actualizar el carrito', 'error');
            });
    }

    // Función para eliminar item del carrito
    const deleteButtons = document.querySelectorAll('.btn-eliminar');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const productoId = form.querySelector('input[name="producto_id"]').value;

            fetch('eliminar_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `producto_id=${productoId}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Eliminar el elemento visualmente
                        const cartItem = this.closest('.cart-item');
                        if (cartItem) {
                            cartItem.style.opacity = '0';
                            setTimeout(() => {
                                cartItem.remove();

                                // Si no quedan items, mostrar carrito vacío
                                const remainingItems = document.querySelectorAll('.cart-item');
                                if (remainingItems.length === 0) {
                                    location.reload(); // Recargar para mostrar el mensaje de carrito vacío
                                }
                            }, 300);
                        }

                        // Actualizar contador del carrito
                        const cartCount = document.querySelector('.carrito-count');
                        if (cartCount) {
                            if (data.total_items > 0) {
                                cartCount.textContent = data.total_items;
                            } else {
                                cartCount.style.display = 'none';
                            }
                        }

                        mostrarNotificacion('Producto eliminado del carrito', 'success');
                    } else {
                        mostrarNotificacion('Error al eliminar el producto', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al eliminar el producto', 'error');
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

    // Función para formatear números con decimales y separadores de miles
    function formatNumber(number) {
        return parseFloat(number).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    // Mostrar modales (reutilizar del index)
    function mostrarModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'block';
    }

    function ocultarModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'none';
    }

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
});
