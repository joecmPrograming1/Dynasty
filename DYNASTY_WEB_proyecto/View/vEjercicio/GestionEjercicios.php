<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/EjercicioController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    // La vista solicita la informacion al controlador (patron MVC)
    $ejercicios = ConsultarEjercicios();

    // Categorías únicas para el filtro
    $categorias = [];
    foreach($ejercicios as $e)
    {
        if(!in_array($e["categoria"], $categorias))
        {
            $categorias[] = $e["categoria"];
        }
    }
    sort($categorias);
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Gestión de ejercicios");
    ?>

    <section class="seccion-sistema">
        <div class="container">

            <?php
                Alertas([
                    "registro"      => "Ejercicio registrado correctamente.",
                    "actualizacion" => "Ejercicio actualizado correctamente.",
                    "estado"        => "Estado del ejercicio actualizado correctamente."
                ]);
            ?>

            <div class="fila-encabezado">
                <div>
                    <div class="section-title">
                        <span>Administración</span>
                        <h2>Catálogo de ejercicios</h2>
                    </div>
                </div>
                <div>
                    <button class="btn-accion" onclick="mostrarFormNuevoEjercicio();">+ Nuevo ejercicio</button>
                </div>
            </div>

            <!-- Formulario nuevo (RF03) -->
            <div class="form-sistema oculto" id="formNuevoEjercicio">
                <h3>Registrar nuevo ejercicio</h3>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre *</label>
                            <input type="text" name="nombre" maxlength="120" required>
                        </div>
                        <div class="col-md-6">
                            <label>Categoría *</label>
                            <input type="text" name="categoria" maxlength="50" placeholder="Ej: Fuerza, Cardio, Movilidad" required>
                        </div>
                    </div>
                    <label>Descripción *</label>
                    <textarea name="descripcion" maxlength="500" required></textarea>
                    <label>Equipo requerido</label>
                    <input type="text" name="equipo" maxlength="150" placeholder="Vacío si no requiere equipo">
                    <button type="submit" name="btnRegistrarEjercicio" class="site-btn">Registrar ejercicio</button>
                </form>
            </div>

            <!-- Formulario edición (RF03) -->
            <div class="form-sistema oculto" id="formEditarEjercicio">
                <h3>Editar ejercicio</h3>
                <form action="" method="post">
                    <input type="hidden" name="idEjercicio" id="edit_idEjercicio">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre *</label>
                            <input type="text" name="nombre" id="edit_nombreEj" maxlength="120" required>
                        </div>
                        <div class="col-md-6">
                            <label>Categoría *</label>
                            <input type="text" name="categoria" id="edit_categoriaEj" maxlength="50" required>
                        </div>
                    </div>
                    <label>Descripción *</label>
                    <textarea name="descripcion" id="edit_descripcionEj" maxlength="500" required></textarea>
                    <label>Equipo requerido</label>
                    <input type="text" name="equipo" id="edit_equipoEj" maxlength="150">
                    <button type="submit" name="btnActualizarEjercicio" class="site-btn">Guardar cambios</button>
                    <button type="button" class="btn-accion peligro ml-10" onclick="cancelarEdicionEjercicio();">Cancelar</button>
                </form>
            </div>

            <!-- Filtros (RF03: buscar sin pantalla adicional) -->
            <div class="filtros-sistema">
                <input type="text" id="filtroNombre" placeholder="Buscar por nombre..." onkeyup="filtrarEjercicios();">
                <select id="filtroCategoria" onchange="filtrarEjercicios();">
                    <option value="">Todas las categorías</option>
                    <?php foreach($categorias as $cat): ?>
                        <option value="<?= htmlspecialchars(strtolower($cat)) ?>"><?= htmlspecialchars($cat) ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="filtroEstado" onchange="filtrarEjercicios();">
                    <option value="">Todos los estados</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
            </div>

            <!-- Listado -->
            <div class="tabla-scroll">
                <table class="tabla-sistema" id="tablaEjercicios">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Equipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($ejercicios) > 0): ?>
                            <?php foreach($ejercicios as $e): ?>
                                <tr data-estado="<?= $e["estado"] ?>">
                                    <td><?= htmlspecialchars($e["nombre_ejercicio"]) ?></td>
                                    <td><?= htmlspecialchars($e["categoria"]) ?></td>
                                    <td><?= htmlspecialchars($e["descripcion"]) ?></td>
                                    <td><?= htmlspecialchars($e["equipo_requerido"]) ?></td>
                                    <td>
                                        <?php if($e["estado"] == 1): ?>
                                            <span class="estado-activo">Activo</span>
                                        <?php else: ?>
                                            <span class="estado-inactivo">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn-accion"
                                            data-id="<?= $e["id_ejercicio"] ?>"
                                            data-nombre="<?= htmlspecialchars($e["nombre_ejercicio"]) ?>"
                                            data-categoria="<?= htmlspecialchars($e["categoria"]) ?>"
                                            data-descripcion="<?= htmlspecialchars($e["descripcion"]) ?>"
                                            data-equipo="<?= htmlspecialchars($e["equipo_requerido"]) ?>"
                                            onclick="editarEjercicio(this);">Editar</button>

                                        <form action="" method="post" class="form-inline"
                                            onsubmit="return confirmarEstado(this, '¿Está seguro de que desea <?= $e["estado"] == 1 ? "desactivar" : "activar" ?> este ejercicio?');">
                                            <input type="hidden" name="idEjercicio" value="<?= $e["id_ejercicio"] ?>">
                                            <input type="hidden" name="estado" value="<?= $e["estado"] == 1 ? 0 : 1 ?>">
                                            <button type="submit" name="btnCambiarEstadoEjercicio"
                                                class="btn-accion <?= $e["estado"] == 1 ? "peligro" : "" ?>">
                                                <?= $e["estado"] == 1 ? "Desactivar" : "Activar" ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="texto-centro">No hay ejercicios registrados.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    <?php FooterExterno(); ?>

    <?php ImportJS(); ?>

</body>
</html>
