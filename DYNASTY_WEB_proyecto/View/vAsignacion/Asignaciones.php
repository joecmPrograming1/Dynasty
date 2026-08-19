<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : Asignaciones.php
 * Proposito: Vista de asignaciones. Asignacion de rutinas y control de su estado.
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/AsignacionController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    // La vista solicita la informacion al controlador (patron MVC)
    $asignaciones = ConsultarAsignaciones();
    $clientes     = ConsultarClientesActivos();
    $rutinas      = ConsultarRutinasActivas();
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Asignaciones");
    ?>

    <section class="seccion-sistema">
        <div class="container-fluid">

            <?php
                Alertas([
                    "asignacion" => "Rutina asignada correctamente."
                ]);
            ?>

            <div class="fila-encabezado">
                <div>
                    <div class="section-title">
                        <span>Administracion</span>
                        <h2>Asignacion de rutinas</h2>
                    </div>
                </div>
                <div>
                    <button class="btn-accion" onclick="mostrarFormAsignacion();">+ Nueva asignacion</button>
                </div>
            </div>

            <!-- Formulario de asignacion -->
            <div class="form-sistema oculto" id="formAsignacion">
                <h3>Asignar rutina a un cliente</h3>

                <?php if(count($clientes) == 0 || count($rutinas) == 0): ?>
                    <div class="aviso">
                        <?php if(count($clientes) == 0): ?>
                            No hay clientes activos registrados.
                        <?php endif; ?>
                        <?php if(count($rutinas) == 0): ?>
                            No hay rutinas activas con ejercicios. Cree una rutina antes de asignar.
                        <?php endif; ?>
                    </div>
                <?php else: ?>

                <form action="" method="post" id="formularioAsignacion">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Cliente *</label>
                            <select name="idCliente" required>
                                <option value="">Seleccione un cliente</option>
                                <?php foreach($clientes as $c): ?>
                                    <option value="<?= $c["id_cliente"] ?>">
                                        <?= htmlspecialchars($c["cliente"]) ?> - <?= htmlspecialchars($c["nivel_actual"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Rutina *</label>
                            <select name="idRutina" required>
                                <option value="">Seleccione una rutina</option>
                                <?php foreach($rutinas as $r): ?>
                                    <option value="<?= $r["id_rutina"] ?>">
                                        <?= htmlspecialchars($r["nombre_rutina"]) ?> - <?= htmlspecialchars($r["nivel"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Fecha de inicio *</label>
                            <input type="date" name="fechaInicio" id="fechaInicio" required>
                        </div>
                        <div class="col-md-6">
                            <label>Fecha de finalizacion</label>
                            <input type="date" name="fechaFin" id="fechaFin">
                            <span class="ayuda-campo">Opcional. No puede ser anterior a la fecha de inicio.</span>
                        </div>
                    </div>

                    <label>Observaciones</label>
                    <textarea name="observacion" maxlength="300"></textarea>

                    <div class="acciones-formulario">
                        <button type="submit" name="btnAsignarRutina" class="site-btn">Asignar rutina</button>
                        <button type="button" class="btn-accion peligro ml-10" onclick="cancelarFormAsignacion();">Cancelar</button>
                    </div>
                </form>

                <?php endif; ?>
            </div>

            <!-- Listado de asignaciones -->
            <div class="tabla-scroll">
                <table class="tabla-sistema" id="tablaAsignaciones">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Identificacion</th>
                            <th>Rutina</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($asignaciones) > 0): ?>
                            <?php foreach($asignaciones as $a): ?>
                                <tr>
                                    <td><?= htmlspecialchars($a["cliente"]) ?></td>
                                    <td><?= htmlspecialchars($a["identificacion"]) ?></td>
                                    <td><?= htmlspecialchars($a["nombre_rutina"]) ?></td>
                                    <td><?= date("d/m/Y", strtotime($a["fecha_inicio"])) ?></td>
                                    <td>
                                        <?= ($a["fecha_fin"] != null)
                                                ? date("d/m/Y", strtotime($a["fecha_fin"]))
                                                : "-" ?>
                                    </td>
                                    <td>
                                        <span class="badge-estado badge-<?= strtolower(str_replace("_", "", $a["estado"])) ?>">
                                            <?= str_replace("_", " ", $a["estado"]) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($a["estado"] == "PENDIENTE" || $a["estado"] == "EN_PROCESO"): ?>
                                            <button type="button" class="btn-accion"
                                                onclick="cambiarEstadoAsignacion(<?= $a["id_asignacion"] ?>, 'FINALIZADA', '<?= htmlspecialchars($a["cliente"], ENT_QUOTES) ?>');">
                                                Finalizar
                                            </button>
                                            <button type="button" class="btn-accion peligro"
                                                onclick="cambiarEstadoAsignacion(<?= $a["id_asignacion"] ?>, 'CANCELADA', '<?= htmlspecialchars($a["cliente"], ENT_QUOTES) ?>');">
                                                Cancelar
                                            </button>
                                        <?php else: ?>
                                            <span class="texto-tenue">Sin acciones</span>
                                        <?php endif; ?>
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
    <script src="/Dynasty/DYNASTY_WEB_proyecto/js/asignaciones.js?v=8"></script>

</body>
</html>
