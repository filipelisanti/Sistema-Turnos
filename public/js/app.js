(function () {
    'use strict';

    // Confirmación antes de acciones destructivas en los formularios de acción
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            var message = form.getAttribute('data-confirm') || '¿Estás seguro de realizar esta acción?';
            if (!window.confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Auto-ocultar mensajes flash después de unos segundos
    document.querySelectorAll('.flash').forEach(function (flash) {
        setTimeout(function () {
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity = '0';
            setTimeout(function () {
                flash.remove();
            }, 500);
        }, 4000);
    });

    // Menú desplegable del header
    var dropdown = document.querySelector('.dropdown');
    var boton = document.getElementById('menuBoton');

    if (dropdown && boton) {
        boton.addEventListener('click', function (e) {
            e.stopPropagation();
            var abierto = dropdown.classList.toggle('abierto');
            boton.setAttribute('aria-expanded', abierto ? 'true' : 'false');
        });

        // Cerrar al hacer clic fuera del menú
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('abierto');
                boton.setAttribute('aria-expanded', 'false');
            }
        });

        // Cerrar con la tecla Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                dropdown.classList.remove('abierto');
                boton.setAttribute('aria-expanded', 'false');
            }
        });
    }
})();
