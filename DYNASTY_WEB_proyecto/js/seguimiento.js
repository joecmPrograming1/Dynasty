'use strict';

// ============================================================
// RF08 - Seguimiento y retroalimentacion
// ============================================================

function abrirRetroalimentacion(idProgreso, cliente, comentario) {
    document.getElementById('idProgresoRetro').value      = idProgreso;
    document.getElementById('nombreClienteRetro').textContent = cliente;
    document.getElementById('comentarioAdminRetro').value = comentario || '';

    var f = document.getElementById('formRetro');
    f.classList.remove('oculto');

    window.scrollTo({ top: f.offsetTop - 120, behavior: 'smooth' });
    document.getElementById('comentarioAdminRetro').focus();
}

function cerrarRetroalimentacion() {
    document.getElementById('formRetro').classList.add('oculto');
}

$(document).ready(function () {

    if ($('#tablaSeguimiento').length) {
        new DataTable('#tablaSeguimiento', {
            pageLength: 10,
            order: [],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json'
            }
        });
    }

});
