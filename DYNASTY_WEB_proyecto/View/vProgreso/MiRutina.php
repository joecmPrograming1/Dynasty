<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : MiRutina.php
 * Proposito: Vista Mi rutina. Consulta de la rutina vigente del cliente.
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/ProgresoController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    // La rutina se obtiene a partir del usuario en sesion (RF06)
    $rutina = ConsultarMiRutina();
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Mi rutina");
    ?>

    <section class="seccion-sistema">
        <div class="container-fluid">

            <?php Alertas(); ?>

            <?php if($rutina): ?>

                <div class="tarjeta-info">
                    <h3><?= htmlspecialchars($rutina["nombre_rutina"]) ?></h3>
                    <p class="meta"><?= htmlspecialchars($rutina["objetivo"]) ?></p>

                    <div class="dato-linea">
                        <div>
                            <span>Nivel</span>
                            <?= htmlspecialchars($rutina["nivel"]) ?>
                        </div>
                        <div>
                            <span>Estado</span>
                            <span class="badge-estado badge-<?= strtolower(str_replace("_", "", $rutina["estado"])) ?>">
                                <?= str_replace("_", " ", $rutina["estado"]) ?>
                            </span>
                        </div>
                        <div>
                            <span>Inicio</span>
                            <?= date("d/m/Y", strtotime($rutina["fecha_inicio"])) ?>
                        </div>
                        <div>
                            <span>Finalizacion</span>
                            <?= ($rutina["fecha_fin"] != null)
                                    ? date("d/m/Y", strtotime($rutina["fecha_fin"]))
                                    : "Sin fecha definida" ?>
                        </div>
                    </div>

                    <?php if($rutina["descripcion_general"] != ""): ?>
                        <div class="dato-linea">
                            <div>
                                <span>Indicaciones generales</span>
                                <?= htmlspecialchars($rutina["descripcion_general"]) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($rutina["observacion_admin"] != ""): ?>
                        <div class="retro-admin">
                            <b>Nota del entrenador</b>
                            <?= htmlspecialchars($rutina["observacion_admin"]) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="section-title">
                    <span>Ejercicios</span>
                    <h2>Plan de entrenamiento</h2>
                </div>

                <?php if(count($rutina["ejercicios"]) > 0): ?>
                    <div class="lista-ejercicios">
                    <?php foreach($rutina["ejercicios"] as $e): ?>
                        <div class="ejercicio-item">
                            <h4>
                                <span class="orden-numero"><?= $e["orden"] ?></span>
                                <?= htmlspecialchars($e["nombre_ejercicio"]) ?>
                            </h4>
                            <div class="categoria"><?= htmlspecialchars($e["categoria"]) ?></div>

                            <div class="parametros">
                                <div>Series: <b><?= $e["series"] ?></b></div>

                                <?php if($e["repeticiones"] != null): ?>
                                    <div>Repeticiones: <b><?= $e["repeticiones"] ?></b></div>
                                <?php endif; ?>

                                <?php if($e["duracion_segundos"] != null): ?>
                                    <div>Duracion: <b><?= $e["duracion_segundos"] ?> s</b></div>
                                <?php endif; ?>

                                <div>Descanso: <b><?= $e["descanso_segundos"] ?> s</b></div>
                            </div>

                            <?php if($e["indicaciones"] != ""): ?>
                                <div class="indicaciones"><?= htmlspecialchars($e["indicaciones"]) ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    </div>

                    <div class="acciones-formulario">
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vProgreso/MiProgreso.php" class="site-btn">
                            Registrar entrenamiento
                        </a>
                    </div>
                <?php else: ?>
                    <div class="mensaje-vacio">
                        <i class="fa fa-list-alt"></i>
                        <h4>La rutina aun no tiene ejercicios</h4>
                        <p>Comuniquese con su entrenador.</p>
                    </div>
                <?php endif; ?>

            <?php else: ?>

                <div class="mensaje-vacio">
                    <i class="fa fa-calendar-o"></i>
                    <h4>No tiene una rutina asignada</h4>
                    <p>Cuando su entrenador le asigne una rutina, aparecera en esta pantalla.</p>
                </div>

            <?php endif; ?>

        </div>
    </section>

    <?php
        FooterExterno();
        ImportJS();
    ?>

</body>
</html>
