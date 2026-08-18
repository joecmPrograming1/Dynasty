'use strict';

// ============================================================
// RF05 - Asignacion de rutinas
// ============================================================

function mostrarFormAsignacion() {
    var f = document.getElementById('formAsignacion');
    f.classList.toggle('oculto');

    if (!f.classList.contains('oculto')) {
        window.scrollTo({ top: f.offsetTop - 120, behavior: 'smooth' });
    }
}

function cancelarFormAsignacion() {
    document.getElementById('formAsignacion').classList.add('oculto');
}

/**
 * Finaliza o cancela una asignacion (RF08).
 */
function cambiarEstadoAsignacion(idAsignacion, estado, cliente) {

    var accion = (estado === 'FINALIZADA') ? 'finalizar' : 'cancelar';

    Swal.fire({
        text: '¿Desea ' + accion + ' la rutina asignada a ' + cliente + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then(function (resultado) {

        if (!resultado.isConfirmed) { return; }

        $.ajax({
            url: '/Dynasty/DYNASTY_WEB_proyecto/Controller/AsignacionController.php',
            type: 'POST',
            dataType: 'json',
            data: {
                CambiarEstadoAsignacion: 'CambiarEstadoAsignacion',
                idAsignacion: idAsignacion,
                estado: estado
            },
            success: function () {
                location.reload();
            },
            error: function () {
                Swal.fire({ icon: 'error', text: 'No se pudo cambiar el estado.' });
            }
        });

    });
}

$(document).ready(function () {

    // La fecha de inicio por defecto es el dia de hoy
    var hoy = new Date().toISOString().split('T')[0];
    var inicio = document.getElementById('fechaInicio');
    if (inicio && inicio.value === '') { inicio.value = hoy; }

    // La fecha de fin no puede ser anterior a la de inicio
    $('#fechaInicio').on('change', function () {
        $('#fechaFin').attr('min', $(this).val());
    });

    $('#formularioAsignacion').on('submit', function (evento) {
        var fi = $('#fechaInicio').val();
        var ff = $('#fechaFin').val();

        if (ff !== '' && ff < fi) {
            evento.preventDefault();
            Swal.fire({ icon: 'warning', text: 'La fecha de finalizacion no puede ser anterior a la fecha de inicio.' });
            return false;
        }
    });

});
