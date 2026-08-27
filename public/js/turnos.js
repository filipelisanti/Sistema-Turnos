(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var btnVer = document.getElementById('ver-disponibilidad');

        // Selección de una hora libre en el calendario
        document.querySelectorAll('#tabla-horarios tr.libre').forEach(function (fila) {
            fila.addEventListener('click', function () {
                seleccionarHora(fila);
            });
        });

        // Recargar disponibilidad según profesional y fecha
        if (btnVer) {
            btnVer.addEventListener('click', function () {
                var prof = document.getElementById('profesional_id').value;
                var fecha = document.getElementById('fecha').value;
                if (!prof || !fecha) {
                    alert('Selecciona profesional y fecha.');
                    return;
                }
                var url = btnVer.getAttribute('data-url');
                window.location.href = url + '?fecha=' + fecha + '&profesional_id=' + prof;
            });
        }
    });

    function seleccionarHora(fila) {
        // Quitar selección previa
        document.querySelectorAll('#tabla-horarios tr.seleccionada').forEach(function (r) {
            r.classList.remove('seleccionada');
            r.classList.add('libre');
        });

        fila.classList.add('seleccionada');
        fila.classList.remove('libre');

        var hora = fila.getAttribute('data-hora');
        var hh = hora.split(':')[0];
        var fin = String(parseInt(hh, 10) + 1).padStart(2, '0') + ':00';

        document.getElementById('hora_inicio').value = hora;
        document.getElementById('hora_fin').value = fin;
        document.getElementById('btn-crear').disabled = false;
    }
})();
