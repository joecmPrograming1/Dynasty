'use strict';

// Confirmación antes de desactivar registros (RF02/RF03)
function confirmarCambioEstado(mensaje) {
    return confirm(mensaje);
}

// Cargar datos de una fila al formulario de edición (Clientes)
function editarCliente(boton) {
    var d = boton.dataset;
    document.getElementById('edit_idCliente').value = d.id;
    document.getElementById('edit_identificacion').value = d.identificacion;
    document.getElementById('edit_nombre').value = d.nombre;
    document.getElementById('edit_apellidos').value = d.apellidos;
    document.getElementById('edit_correo').value = d.correo;
    document.getElementById('edit_telefono').value = d.telefono;
    document.getElementById('edit_objetivo').value = d.objetivo;
    document.getElementById('edit_nivel').value = d.nivel;
    document.getElementById('edit_disponibilidad').value = d.disponibilidad;
    document.getElementById('edit_observaciones').value = d.observaciones;
    document.getElementById('formEditarCliente').style.display = 'block';
    window.scrollTo({ top: document.getElementById('formEditarCliente').offsetTop - 100, behavior: 'smooth' });
}

function cancelarEdicionCliente() {
    document.getElementById('formEditarCliente').style.display = 'none';
}

// Cargar datos de una fila al formulario de edición (Ejercicios)
function editarEjercicio(boton) {
    var d = boton.dataset;
    document.getElementById('edit_idEjercicio').value = d.id;
    document.getElementById('edit_nombreEj').value = d.nombre;
    document.getElementById('edit_categoriaEj').value = d.categoria;
    document.getElementById('edit_descripcionEj').value = d.descripcion;
    document.getElementById('edit_equipoEj').value = d.equipo;
    document.getElementById('formEditarEjercicio').style.display = 'block';
    document.getElementById('formNuevoEjercicio').style.display = 'none';
    window.scrollTo({ top: document.getElementById('formEditarEjercicio').offsetTop - 100, behavior: 'smooth' });
}

function cancelarEdicionEjercicio() {
    document.getElementById('formEditarEjercicio').style.display = 'none';
}

function mostrarFormNuevoEjercicio() {
    var f = document.getElementById('formNuevoEjercicio');
    f.style.display = (f.style.display === 'none' || f.style.display === '') ? 'block' : 'none';
    document.getElementById('formEditarEjercicio').style.display = 'none';
}

// Filtro de la tabla de ejercicios (RF03: buscar por nombre, filtrar por categoría/estado)
function filtrarEjercicios() {
    var texto = document.getElementById('filtroNombre').value.toLowerCase();
    var categoria = document.getElementById('filtroCategoria').value.toLowerCase();
    var estado = document.getElementById('filtroEstado').value;

    var filas = document.querySelectorAll('#tablaEjercicios tbody tr');
    filas.forEach(function (fila) {
        var nombre = fila.cells[0].textContent.toLowerCase();
        var cat = fila.cells[1].textContent.toLowerCase();
        var est = fila.dataset.estado;

        var visible = nombre.indexOf(texto) !== -1
            && (categoria === '' || cat === categoria)
            && (estado === '' || est === estado);

        fila.style.display = visible ? '' : 'none';
    });
}

// Mostrar/ocultar contraseña con el ojito (RF01 - usabilidad)
function alternarContrasena(icono) {
    var input = icono.previousElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        icono.classList.remove('fa-eye');
        icono.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icono.classList.remove('fa-eye-slash');
        icono.classList.add('fa-eye');
    }
}

// ============================================================
// DataTables y SweetAlert2 (tecnicas vistas en clase)
// ============================================================

$(document).ready(function () {

    var configuracion = {
        pageLength: 10,
        order: [],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json'
        },
        columnDefs: [
            { targets: -1, orderable: false, searchable: false }
        ]
    };

    ['#tablaClientesLista', '#tablaEjercicios', '#tablaRutinas', '#tablaAsignaciones'].forEach(function (id) {
        if ($(id).length) {
            new DataTable(id, configuracion);
        }
    });

});

/**
 * Confirmacion con SweetAlert antes de cambiar el estado de un registro.
 * Reemplaza el confirm() del navegador.
 */
function confirmarEstado(formulario, mensaje) {

    Swal.fire({
        text: mensaje,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then(function (resultado) {
        if (resultado.isConfirmed) {
            formulario.submit();
        }
    });

    return false;
}
