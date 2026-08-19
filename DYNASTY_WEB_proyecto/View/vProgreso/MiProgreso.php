<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : MiProgreso.php
 * Proposito: Vista Mi progreso. Registro e historial de entrenamientos del cliente.
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/ProgresoController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    // Informacion obtenida a partir del usuario en sesion (RF07)
    $rutina    = ConsultarMiRutina();
    $historial = ConsultarMiProgreso();
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Mi progreso");
    ?>

    <section class="seccion-sistema">
        <div class="container-fluid">

            <?php
                Alertas([
                    "registro"      => "Entrenamiento registrado correctamente.",
                    "actualizacion" => "El entrenamiento de esa fecha se actualizo correctamente."
                ]);
            ?>

            <?php if($rutina): ?>

                <div class="row">
                    <div class="col-12">
                        <div class="form-sistema">
                            <h3>Registrar entrenamiento</h3>
                            <p class="nota-formulario">
                                Rutina vigente: <b><?= htmlspecialchars($rutina["nombre_rutina"]) ?></b>
                            </p>

                            <form action="" method="post" id="formProgreso">
                                <input type="hidden" name="idAsignacion" value="<?= $rutina["id_asignacion"] ?>">

                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <label>Fecha del entrenamiento *</label>
                                        <input type="date" name="fechaEntrenamiento" id="fechaEntrenamiento"
                                               min="<?= $rutina["fecha_inicio"] ?>"
                                               max="<?= date("Y-m-d") ?>"
                                               value="<?= date("Y-m-d") ?>" required>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label>Cumplimiento *</label>
                                        <select name="cumplimiento" required>
                                            <option value="COMPLETO">Completo</option>
                                            <option value="PARCIAL">Parcial</option>
                                            <option value="NO_REALIZADO">No realizado</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label>Percepcion de esfuerzo (1 a 10) *</label>
                                        <input type="number" name="esfuerzo" min="1" max="10" value="5" required>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label>Duracion (minutos)</label>
                                        <input type="number" name="duracion" min="0" max="600">
                                    </div>
                                </div>

                                <label>Comentario</label>
                                <textarea name="comentario" maxlength="500"></textarea>

                                <div class="acciones-formulario">
                                    <button type="submit" name="btnRegistrarProgreso" class="site-btn">Guardar entrenamiento</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <span>Historial</span>
                            <h2>Mis entrenamientos</h2>
                        </div>

                        <?php if(count($historial) > 0): ?>
                            <div class="tabla-scroll">
                                <table class="tabla-sistema" id="tablaProgreso">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Rutina</th>
                                            <th>Cumplimiento</th>
                                            <th>Esfuerzo</th>
                                            <th>Duracion</th>
                                            <th>Retroalimentacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($historial as $p): ?>
                                            <tr>
                                                <td><?= date("d/m/Y", strtotime($p["fecha_entrenamiento"])) ?></td>
                                                <td><?= htmlspecialchars($p["nombre_rutina"]) ?></td>
                                                <td>
                                                    <span class="badge-estado badge-<?= strtolower($p["estado_cumplimiento"]) ?>">
                                                        <?= str_replace("_", " ", $p["estado_cumplimiento"]) ?>
                                                    </span>
                                                </td>
                                                <td><?= $p["percepcion_esfuerzo"] ?>/10</td>
                                                <td>
                                                    <?= ($p["duracion_minutos"] != null)
                                                            ? $p["duracion_minutos"] . " min"
                                                            : "-" ?>
                                                </td>
                                                <td>
                                                    <?php if($p["comentario_admin"] != ""): ?>
                                                        <div class="retro-admin">
                                                            <b>Entrenador</b>
                                                            <?= htmlspecialchars($p["comentario_admin"]) ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="texto-tenue">Sin retroalimentacion</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="mensaje-vacio">
                                <i class="fa fa-line-chart"></i>
                                <h4>Aun no ha registrado entrenamientos</h4>
                                <p>Complete el formulario para registrar su primer entrenamiento.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>

                <div class="mensaje-vacio">
                    <i class="fa fa-calendar-o"></i>
                    <h4>No tiene una rutina asignada</h4>
                    <p>Necesita una rutina vigente para poder registrar sus entrenamientos.</p>
                </div>

            <?php endif; ?>

        </div>
    </section>

    <?php
        FooterExterno();
        ImportJS();
    ?>
    <script src="/Dynasty/DYNASTY_WEB_proyecto/js/progreso.js?v=9"></script>

</body>
</html>
