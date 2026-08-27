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
})();
