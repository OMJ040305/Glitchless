// Funcionalidad para las pestañas del perfil
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover clase active de todos los botones
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Remover clase active de todos los contenidos
            tabContents.forEach(content => {
                content.classList.remove('active');
            });

            // Agregar clase active al botón clickeado
            this.classList.add('active');

            // Mostrar el contenido correspondiente
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Funcionalidad para el modal de direcciones
    const modal = document.getElementById('direccion-modal');
    const btnAdd = document.getElementById('btn-add-direccion');
    const closeBtn = document.querySelector('.close');
    const form = document.getElementById('form-direccion');

    // Si existen los elementos en el DOM
    if (modal && btnAdd && closeBtn) {
        // Abrir modal al hacer clic en "Agregar dirección"
        btnAdd.addEventListener('click', function() {
            // Resetear el formulario y cambiar título a "Agregar nueva dirección"
            form.reset();
            document.getElementById('direccion_id').value = '';
            document.getElementById('modal-title').textContent = 'Agregar nueva dirección';
            modal.style.display = 'block';
        });

        // Cerrar modal al hacer clic en la X
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Cerrar modal al hacer clic fuera del contenido
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Funcionalidad para botones de editar dirección
        const editButtons = document.querySelectorAll('.btn-edit-direccion');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const direccionId = this.getAttribute('data-id');

                // Aquí se haría una petición AJAX para obtener los datos de la dirección
                // Por ahora simularemos con un fetch básico
                fetch(`../../../includes/obtener_direccion.php?id=${direccionId}`)
                    .then(response => response.json())
                    .then(direccion => {
                        // Rellenar el formulario con los datos obtenidos
                        document.getElementById('direccion_id').value = direccion.id;
                        document.getElementById('nombre_receptor').value = direccion.nombre_receptor;
                        document.getElementById('telefono_contacto').value = direccion.telefono_contacto;
                        document.getElementById('calle').value = direccion.calle;
                        document.getElementById('numero_exterior').value = direccion.numero_exterior;
                        document.getElementById('numero_interior').value = direccion.numero_interior || '';
                        document.getElementById('colonia').value = direccion.colonia;
                        document.getElementById('codigo_postal').value = direccion.codigo_postal;
                        document.getElementById('ciudad').value = direccion.ciudad;
                        document.getElementById('estado').value = direccion.estado;
                        document.getElementById('referencias').value = direccion.referencias || '';
                        document.getElementById('es_predeterminada').checked = direccion.es_predeterminada == 1;

                        // Cambiar título y abrir modal
                        document.getElementById('modal-title').textContent = 'Editar dirección';
                        modal.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos de la dirección:', error);
                        alert('Error al cargar los datos de la dirección. Por favor, inténtalo de nuevo.');
                    });
            });
        });

        // Funcionalidad para botones de eliminar dirección
        const deleteButtons = document.querySelectorAll('.btn-delete-direccion');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const direccionId = this.getAttribute('data-id');

                if (confirm('¿Estás seguro de que deseas eliminar esta dirección?')) {
                    // Enviar solicitud de eliminación
                    fetch('../../../includes/eliminar_direccion.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `direccion_id=${direccionId}`
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Recargar la página o actualizar la UI
                                location.reload();
                            } else {
                                alert('Error al eliminar la dirección: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error al eliminar la dirección:', error);
                            alert('Error al eliminar la dirección. Por favor, inténtalo de nuevo.');
                        });
                }
            });
        });

        // Funcionalidad para botones de hacer predeterminada
        const defaultButtons = document.querySelectorAll('.btn-default-direccion');

        defaultButtons.forEach(button => {
            button.addEventListener('click', function() {
                const direccionId = this.getAttribute('data-id');

                // Enviar solicitud para hacer predeterminada
                fetch('../../../includes/predeterminar_direccion.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `direccion_id=${direccionId}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Recargar la página o actualizar la UI
                            location.reload();
                        } else {
                            alert('Error al establecer como predeterminada: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error al establecer como predeterminada:', error);
                        alert('Error al establecer como predeterminada. Por favor, inténtalo de nuevo.');
                    });
            });
        });
    }
});