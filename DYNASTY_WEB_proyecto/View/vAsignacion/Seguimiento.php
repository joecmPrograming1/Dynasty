<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/SeguimientoController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    // La vista solicita la informacion al controlador (patron MVC)
    $registros = ConsultarSeguimiento();
    $clientes  = ConsultarClientesSeguimiento();

    $filtroCliente = isset($_GET["filtroCliente"]) ? $_GET["filtroCliente"] : "";
    $filtroInicio  = isset($_GET["filtroInicio"])  ? $_GET["filtroInicio"]  : "";
    $filtroFin     = isset($_GET["filtroFin"])     ? $_GET["filtroFin"]     : "";
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Seguimiento");
    ?>

    <section class="seccion-sistema">
        <div class="container">

            <?php
                Alertas([
                    "retroalimentacion" => "Retroalimentacion guardada correctamente."
                ]);
            ?>

            <div class="section-title">
                <span>Administracion</span>
                <h2>Seguimiento del progreso</h2>
            </div>

            <!-- Filtros por cliente y por rango de fechas (RF08) -->
            <form action="" method="get" class="filtros-sistema">
                <select name="filtroCliente">
                    <option value="">Todos los clientes</option>
                    <?php foreach($clientes as $c): ?>
                        <option value="<?= $c["id_cliente"] ?>" <?= ($filtroCliente == $c["id_cliente"]) ? "selected" : "" ?>>
                            <?= htmlspecialchars($c["cliente"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="date" name="filtroInicio" value="<?= htmlspecialchars($filtroInicio) ?>" title="Desde">
                <input type="date" name="filtroFin" value="<?= htmlspecialchars($filtroFin) ?>" title="Hasta">

                <button type="submit" class="btn-accion">Filtrar</button>
                <a href="Seguimiento.php" class="btn-accion peligro">Limpiar</a>
            </form>

            <!-- Resultados -->
            <?php if(count($registros) > 0): ?>
                <div class="tabla-scroll">
                    <table class="tabla-sistema" id="tablaSeguimiento">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Rutina</th>
                                <th>Fecha</th>
                                <th>Cumplimiento</th>
                                <th>Esfuerzo</th>
                                <th>Duracion</th>
                                <th>Comentario del cliente</th>
                                <th>Retroalimentacion</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($registros as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p["cliente"]) ?></td>
                                    <td><?= htmlspecialchars($p["nombre_rutina"]) ?></td>
                                    <td><?= date("d/m/Y", strtotime($p["fecha_entrenamiento"])) ?></td>
                                    <td>
                                        <span class="badge-estado badge-<?= strtolower($p["estado_cumplimiento"]) ?>">
                                            <?= str_replace("_", " ", $p["estado_cumplimiento"]) ?>
                                        </span>
                                    </td>
                                    <td><?= $p["percepcion_esfuerzo"] ?>/10</td>
                                    <td>
                                        <?= ($p["duracion_minutos"] != null) ? $p["duracion_minutos"] . " min" : "-" ?>
                                    </td>
                                    <td>
                                        <?= ($p["comentario_cliente"] != "")
                                                ? htmlspecialchars($p["comentario_cliente"])
                                                : "-" ?>
                                    </td>
                                    <td>
                                        <?php if($p["comentario_admin"] != ""): ?>
                                            <?= htmlspecialchars($p["comentario_admin"]) ?>
                                            <br>
                                            <small class="texto-tenue">
                                                <?= date("d/m/Y", strtotime($p["fecha_retroalimentacion"])) ?>
                                            </small>
                                        <?php else: ?>
                                            <span class="texto-tenue">Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn-accion"
                                            onclick="abrirRetroalimentacion(<?= $p["id_progreso"] ?>, '<?= htmlspecialchars($p["cliente"], ENT_QUOTES) ?>', '<?= htmlspecialchars($p["comentario_admin"], ENT_QUOTES) ?>');">
                                            <?= ($p["comentario_admin"] != "") ? "Editar" : "Comentar" ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="mensaje-vacio">
                    <i class="fa fa-search"></i>
                    <h4>No hay registros de progreso</h4>
                    <p>No se encontraron entrenamientos con los filtros seleccionados.</p>
                </div>
            <?php endif; ?>

            <!-- Formulario de retroalimentacion -->
            <div class="form-sistema oculto" id="formRetro">
                <h3>Retroalimentacion para <span id="nombreClienteRetro"></span></h3>

                <form action="" method="post">
                    <input type="hidden" name="idProgreso" id="idProgresoRetro">
                    <input type="hidden" name="filtroCliente" value="<?= htmlspecialchars($filtroCliente) ?>">
                    <input type="hidden" name="filtroInicio" value="<?= htmlspecialchars($filtroInicio) ?>">
                    <input type="hidden" name="filtroFin" value="<?= htmlspecialchars($filtroFin) ?>">

                    <label>Comentario *</label>
                    <textarea name="comentarioAdmin" id="comentarioAdminRetro" maxlength="500" required></textarea>

                    <div class="acciones-formulario">
                        <button type="submit" name="btnRetroalimentacion" class="site-btn">Guardar retroalimentacion</button>
                        <button type="button" class="btn-accion peligro ml-10" onclick="cerrarRetroalimentacion();">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <?php
        FooterExterno();
        ImportJS();
    ?>
    <script src="/Dynasty/DYNASTY_WEB_proyecto/js/seguimiento.js"></script>

</body>
</html>
