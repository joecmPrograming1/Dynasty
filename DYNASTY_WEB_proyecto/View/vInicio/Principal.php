<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/PrincipalController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    $esAdmin = ($_SESSION["Rol"] == "ADMINISTRADOR");

    // La vista solicita la informacion al controlador (patron MVC)
    $resumen = $esAdmin ? ConsultarResumenPanel() : ConsultarResumenCliente();
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Principal");
    ?>

    <section class="seccion-sistema">
        <div class="container">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="section-title">
                        <span>Bienvenido, <?= htmlspecialchars($_SESSION["NombreUsuario"]) ?></span>
                        <h2><?= $esAdmin ? "Panel administrativo" : "Mi espacio de entrenamiento" ?></h2>
                    </div>
                </div>
            </div>

            <?php if($esAdmin): ?>

            <div class="row g-cards">
                <div class="col-md-3 col-sm-6">
                    <div class="panel-card">
                        <i class="fa fa-users"></i>
                        <span class="numero"><?= $resumen["clientes"] ?></span>
                        <h4>Clientes activos</h4>
                        <p>Consulte, edite y administre los clientes registrados.</p>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vCliente/GestionClientes.php" class="btn-accion">Gestionar</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="panel-card">
                        <i class="fa fa-heartbeat"></i>
                        <span class="numero"><?= $resumen["ejercicios"] ?></span>
                        <h4>Ejercicios activos</h4>
                        <p>Administre el catalogo de ejercicios del sistema.</p>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vEjercicio/GestionEjercicios.php" class="btn-accion">Gestionar</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="panel-card">
                        <i class="fa fa-list-alt"></i>
                        <span class="numero"><?= $resumen["rutinas"] ?></span>
                        <h4>Rutinas activas</h4>
                        <p>Cree rutinas y defina sus ejercicios ordenados.</p>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vRutina/GestionRutinas.php" class="btn-accion">Gestionar</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="panel-card">
                        <i class="fa fa-calendar-check-o"></i>
                        <span class="numero"><?= $resumen["asignaciones"] ?></span>
                        <h4>Asignaciones en proceso</h4>
                        <p>Asigne rutinas y revise el progreso reportado.</p>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vAsignacion/Asignaciones.php" class="btn-accion">Gestionar</a>
                    </div>
                </div>
            </div>

            <?php else: ?>

            <div class="row g-cards">
                <div class="col-md-6">
                    <div class="panel-card">
                        <i class="fa fa-calendar-check-o"></i>
                        <?php if($resumen["rutina"]): ?>
                            <h4><?= htmlspecialchars($resumen["rutina"]["nombre_rutina"]) ?></h4>
                            <p>
                                Rutina vigente desde el
                                <?= date("d/m/Y", strtotime($resumen["rutina"]["fecha_inicio"])) ?>.
                            </p>
                        <?php else: ?>
                            <h4>Mi rutina</h4>
                            <p>Todavia no tiene una rutina asignada por su entrenador.</p>
                        <?php endif; ?>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vProgreso/MiRutina.php" class="btn-accion">Ver rutina</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel-card">
                        <i class="fa fa-line-chart"></i>
                        <span class="numero"><?= $resumen["entrenamientos"] ?></span>
                        <h4>Entrenamientos registrados</h4>
                        <p>Reporte sus entrenamientos y revise la retroalimentacion.</p>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vProgreso/MiProgreso.php" class="btn-accion">Registrar</a>
                    </div>
                </div>
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
