'use strict';

/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : seguimiento.js
 * Proposito: Seguimiento. Formulario de retroalimentacion del entrenador.
 * Requerim.: RF08
 * ============================================================ */

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
        new DataTable('#tablaSeguimiento', configuracionTabla(true));
    }

});
