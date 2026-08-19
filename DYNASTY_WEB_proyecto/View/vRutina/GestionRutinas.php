<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : GestionRutinas.php
 * Proposito: Vista de rutinas. Rutinas con su detalle ordenado de ejercicios.
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/RutinaController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    // La vista solicita la informacion al controlador (patron MVC)
    $rutinas    = ConsultarRutinas();
    $ejercicios = ConsultarEjerciciosActivos();
    $niveles    = ConsultarNivelesRutina();
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Rutinas");
    ?>

    <section class="seccion-sistema">
        <div class="container-fluid">

            <?php
                Alertas([
                    "registro"      => "Rutina registrada correctamente.",
                    "actualizacion" => "Rutina actualizada correctamente."
                ]);
            ?>

            <div class="fila-encabezado">
                <div>
                    <div class="section-title">
                        <span>Administracion</span>
                        <h2>Catalogo de rutinas</h2>
                    </div>
                </div>
                <div>
                    <button class="btn-accion" onclick="mostrarFormRutina();">+ Nueva rutina</button>
                </div>
            </div>

            <!-- Formulario de rutina (registro y edicion) -->
            <div class="form-sistema oculto" id="formRutina">
                <h3 id="tituloFormRutina">Registrar nueva rutina</h3>

                <form action="" method="post" id="formularioRutina">
                    <input type="hidden" name="idRutina" id="idRutina">

                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre de la rutina *</label>
                            <input type="text" name="nombre" id="nombreRutina" maxlength="120" required>
                        </div>
                        <div class="col-md-6">
                            <label>Objetivo *</label>
                            <input type="text" name="objetivo" id="objetivoRutina" maxlength="180" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Nivel *</label>
                            <select name="nivel" id="nivelRutina" required>
                                <?php foreach($niveles as $n): ?>
                                    <option value="<?= htmlspecialchars($n['codigo_nivel']) ?>"><?= htmlspecialchars($n['descripcion']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 oculto" id="campoEstadoRutina">
                            <label>Estado</label>
                            <select name="estado" id="estadoRutina">
                                <option value="1">Activa</option>
                                <option value="0">Inactiva</option>
                            </select>
                        </div>
                    </div>

                    <label>Descripcion general</label>
                    <textarea name="descripcion" id="descripcionRutina" maxlength="500"></textarea>

                    <div class="aviso oculto" id="avisoRutinaAsignada">
                        Esta rutina ya fue asignada a un cliente. Los cambios afectaran la visualizacion vigente;
                        el historial de progreso no se elimina.
                    </div>

                    <h4 class="subtitulo-detalle">Ejercicios de la rutina</h4>
                    <p class="nota-formulario">
                        Indique las series y al menos un valor entre repeticiones o duracion. El orden no puede repetirse.
                    </p>

                    <div class="tabla-scroll">
                        <table class="tabla-detalle" id="tablaDetalle">
                            <thead>
                                <tr>
                                    <th style="width:70px;">Orden</th>
                                    <th>Ejercicio</th>
                                    <th style="width:90px;">Series</th>
                                    <th style="width:110px;">Repeticiones</th>
                                    <th style="width:110px;">Duracion (s)</th>
                                    <th style="width:110px;">Descanso (s)</th>
                                    <th>Indicaciones</th>
                                    <th style="width:60px;"></th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoDetalle"></tbody>
                        </table>
                    </div>

                    <button type="button" class="btn-accion" onclick="agregarFilaDetalle();">+ Agregar ejercicio</button>

                    <div class="acciones-formulario">
                        <button type="submit" name="btnRegistrarRutina" id="btnRegistrarRutina" class="site-btn">Registrar rutina</button>
                        <button type="submit" name="btnActualizarRutina" id="btnActualizarRutina" class="site-btn oculto">Guardar cambios</button>
                        <button type="button" class="btn-accion peligro ml-10" onclick="cancelarFormRutina();">Cancelar</button>
                    </div>
                </form>
            </div>

            <!-- Listado de rutinas -->
            <div class="tabla-scroll">
                <table class="tabla-sistema" id="tablaRutinas">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Objetivo</th>
                            <th>Nivel</th>
                            <th>Ejercicios</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($rutinas) > 0): ?>
                            <?php foreach($rutinas as $r): ?>
                                <tr>
                                    <td><?= htmlspecialchars($r["nombre_rutina"]) ?></td>
                                    <td><?= htmlspecialchars($r["objetivo"]) ?></td>
                                    <td><?= htmlspecialchars($r["nivel"]) ?></td>
                                    <td><?= $r["total_ejercicios"] ?></td>
                                    <td>
                                        <?php if($r["estado"] == 1): ?>
                                            <span class="estado-activo">Activa</span>
                                        <?php else: ?>
                                            <span class="estado-inactivo">Inactiva</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn-accion"
                                            onclick="editarRutina(<?= $r["id_rutina"] ?>);">Editar</button>

                                        <button type="button"
                                            class="btn-accion <?= $r["estado"] == 1 ? "peligro" : "" ?>"
                                            onclick="cambiarEstadoRutina(<?= $r["id_rutina"] ?>, <?= $r["estado"] == 1 ? 0 : 1 ?>, '<?= htmlspecialchars($r["nombre_rutina"], ENT_QUOTES) ?>');">
                                            <?= $r["estado"] == 1 ? "Desactivar" : "Activar" ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    <?php
        FooterExterno();
        ImportJS();
    ?>

    <!-- Catalogo de ejercicios disponible para el detalle -->
    <script>
        var EJERCICIOS = <?= json_encode($ejercicios) ?>;
    </script>
    <script src="/Dynasty/DYNASTY_WEB_proyecto/js/rutinas.js?v=8"></script>

</body>
</html>
