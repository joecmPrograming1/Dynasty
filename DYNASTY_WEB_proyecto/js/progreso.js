'use strict';

/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : progreso.js
 * Proposito: Registro de progreso. Validaciones del formulario de entrenamiento del cliente.
 * Requerim.: RF07
 * ============================================================ */

$(document).ready(function () {

    if ($('#tablaProgreso').length) {
        new DataTable('#tablaProgreso', configuracionTabla(false));
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
