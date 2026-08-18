'use strict';

// ============================================================
// RF04 - Gestion de rutinas
// Construccion dinamica del detalle de ejercicios
// ============================================================

var contadorFilas = 0;

/**
 * Devuelve las opciones del selector de ejercicios.
 */
function OpcionesEjercicios(seleccionado) {
    var html = '<option value="">Seleccione un ejercicio</option>';

    EJERCICIOS.forEach(function (e) {
        var marca = (String(e.id_ejercicio) === String(seleccionado)) ? ' selected' : '';
        html += '<option value="' + e.id_ejercicio + '"' + marca + '>'
              + e.nombre_ejercicio + ' (' + e.categoria + ')</option>';
    });

    return html;
}

/**
 * Agrega una fila al detalle de la rutina.
 */
function agregarFilaDetalle(datos) {
    contadorFilas++;

    var d = datos || {};
    var orden = d.orden || (document.querySelectorAll('#cuerpoDetalle tr').length + 1);

    var fila = document.createElement('tr');
    fila.innerHTML =
        '<td><input type="number" name="orden[]" min="1" value="' + orden + '" required></td>' +
        '<td><select name="idEjercicio[]" required>' + OpcionesEjercicios(d.id_ejercicio) + '</select></td>' +
        '<td><input type="number" name="series[]" min="1" max="20" value="' + (d.series || '') + '" required></td>' +
        '<td><input type="number" name="repeticiones[]" min="1" value="' + (d.repeticiones || '') + '"></td>' +
        '<td><input type="number" name="duracion[]" min="1" value="' + (d.duracion_segundos || '') + '"></td>' +
        '<td><input type="number" name="descanso[]" min="0" value="' + (d.descanso_segundos || 0) + '"></td>' +
        '<td><input type="text" name="indicaciones[]" maxlength="300" value="' + (d.indicaciones || '') + '"></td>' +
        '<td class="texto-centro">' +
            '<button type="button" class="btn-quitar" onclick="quitarFilaDetalle(this);" title="Quitar">&times;</button>' +
        '</td>';

    document.getElementById('cuerpoDetalle').appendChild(fila);
}

function quitarFilaDetalle(boton) {
    var fila = boton.closest('tr');
    fila.parentNode.removeChild(fila);
}

/**
 * Muestra el formulario en modo registro.
 */
function mostrarFormRutina() {
    document.getElementById('formularioRutina').reset();
    document.getElementById('idRutina').value = '';
    document.getElementById('cuerpoDetalle').innerHTML = '';

    document.getElementById('tituloFormRutina').textContent = 'Registrar nueva rutina';
    document.getElementById('btnRegistrarRutina').classList.remove('oculto');
    document.getElementById('btnActualizarRutina').classList.add('oculto');
    document.getElementById('campoEstadoRutina').classList.add('oculto');
    document.getElementById('avisoRutinaAsignada').classList.add('oculto');

    document.getElementById('formRutina').classList.remove('oculto');
    agregarFilaDetalle();

    window.scrollTo({ top: document.getElementById('formRutina').offsetTop - 120, behavior: 'smooth' });
}

function cancelarFormRutina() {
    document.getElementById('formRutina').classList.add('oculto');
}

/**
 * Carga una rutina existente en el formulario (AJAX).
 */
function editarRutina(idRutina) {

    $.ajax({
        url: '/Dynasty/DYNASTY_WEB_proyecto/Controller/RutinaController.php',
        type: 'POST',
        dataType: 'json',
        data: {
            ConsultarDetalleRutina: 'ConsultarDetalleRutina',
            idRutina: idRutina
        },
        success: function (respuesta) {

            if (respuesta.status !== 'Ok') {
                Swal.fire({ icon: 'error', text: 'No se pudo cargar la rutina.' });
                return;
            }

            var r = respuesta.rutina;

            document.getElementById('idRutina').value          = r.id_rutina;
            document.getElementById('nombreRutina').value      = r.nombre_rutina;
            document.getElementById('objetivoRutina').value    = r.objetivo;
            document.getElementById('nivelRutina').value       = r.nivel;
            document.getElementById('descripcionRutina').value = r.descripcion_general || '';
            document.getElementById('estadoRutina').value      = r.estado;

            document.getElementById('cuerpoDetalle').innerHTML = '';
            respuesta.detalle.forEach(function (d) {
                agregarFilaDetalle(d);
            });

            document.getElementById('tituloFormRutina').textContent = 'Editar rutina';
            document.getElementById('btnRegistrarRutina').classList.add('oculto');
            document.getElementById('btnActualizarRutina').classList.remove('oculto');
            document.getElementById('campoEstadoRutina').classList.remove('oculto');

            // Aviso cuando la rutina ya fue asignada a un cliente
            if (respuesta.asignada) {
                document.getElementById('avisoRutinaAsignada').classList.remove('oculto');
            } else {
                document.getElementById('avisoRutinaAsignada').classList.add('oculto');
            }

            document.getElementById('formRutina').classList.remove('oculto');
            window.scrollTo({ top: document.getElementById('formRutina').offsetTop - 120, behavior: 'smooth' });
        },
        error: function () {
            Swal.fire({ icon: 'error', text: 'Ocurrio un error al consultar la rutina.' });
        }
    });
}

/**
 * Activa o desactiva una rutina.
 */
function cambiarEstadoRutina(idRutina, estado, nombre) {

    var accion = (estado === 1) ? 'activar' : 'desactivar';

    Swal.fire({
        text: '¿Desea ' + accion + ' la rutina "' + nombre + '"?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then(function (resultado) {

        if (!resultado.isConfirmed) { return; }

        $.ajax({
            url: '/Dynasty/DYNASTY_WEB_proyecto/Controller/RutinaController.php',
            type: 'POST',
            dataType: 'json',
            data: {
                CambiarEstadoRutina: 'CambiarEstadoRutina',
                idRutina: idRutina,
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

// Validacion en el navegador antes de enviar el formulario
$(document).ready(function () {

    $('#formularioRutina').on('submit', function (evento) {

        var filas = document.querySelectorAll('#cuerpoDetalle tr');

        if (filas.length === 0) {
            evento.preventDefault();
            Swal.fire({ icon: 'warning', text: 'La rutina debe tener al menos un ejercicio.' });
            return false;
        }

        var ordenes = [];
        var valido  = true;

        filas.forEach(function (fila) {
            var orden        = fila.querySelector('[name="orden[]"]').value;
            var repeticiones = fila.querySelector('[name="repeticiones[]"]').value;
            var duracion     = fila.querySelector('[name="duracion[]"]').value;

            if (ordenes.indexOf(orden) !== -1) {
                valido = false;
                Swal.fire({ icon: 'warning', text: 'El orden de los ejercicios no puede repetirse.' });
                return;
            }
            ordenes.push(orden);

            if ((repeticiones === '' || Number(repeticiones) <= 0) &&
                (duracion === '' || Number(duracion) <= 0)) {
                valido = false;
                Swal.fire({ icon: 'warning', text: 'Cada ejercicio debe indicar repeticiones o duracion.' });
                return;
            }
        });

        if (!valido) {
            evento.preventDefault();
            return false;
        }
    });

});
