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
});
