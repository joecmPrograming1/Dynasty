'use strict';

// ============================================================
// RF07 - Registro de progreso del cliente
// ============================================================

$(document).ready(function () {

    if ($('#tablaProgreso').length) {
        new DataTable('#tablaProgreso', {
            pageLength: 10,
            order: [],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json'
            }
        });
    }

    $('#formProgreso').on('submit', function (evento) {

        var fecha = $('#fechaEntrenamiento').val();
        var hoy   = new Date().toISOString().split('T')[0];

        if (fecha === '') {
            evento.preventDefault();
            Swal.fire({ icon: 'warning', text: 'Debe indicar la fecha del entrenamiento.' });
            return false;
        }

        if (fecha > hoy) {
            evento.preventDefault();
            Swal.fire({ icon: 'warning', text: 'La fecha no puede ser posterior al dia de hoy.' });
            return false;
        }
    });

});
