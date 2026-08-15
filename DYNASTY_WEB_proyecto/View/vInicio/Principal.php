<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/PrincipalController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    $esAdmin = ($_SESSION["Rol"] == "ADMINISTRADOR");

    $resumen = ConsultarResumenPanel();
    $totalClientes   = $resumen["clientes"];
    $totalEjercicios = $resumen["ejercicios"];
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Bienvenido, <?= htmlspecialchars($_SESSION["NombreUsuario"]) ?></span>
                        <h2><?= $esAdmin ? "Panel administrativo" : "Mi espacio de entrenamiento" ?></h2>
                    </div>
                </div>
            </div>

            <?php if($esAdmin): ?>
            <div class="row g-cards">
                <div class="col-md-4">
                    <div class="panel-card">
                        <i class="fa fa-users"></i>
                        <span class="numero"><?= $totalClientes ?></span>
                        <h4>Clientes activos</h4>
                        <p>Registre, edite y administre los clientes del servicio.</p>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vCliente/GestionClientes.php" class="btn-accion">Gestionar</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel-card">
                        <i class="fa fa-heartbeat"></i>
                        <span class="numero"><?= $totalEjercicios ?></span>
                        <h4>Ejercicios activos</h4>
                        <p>Administre el catálogo de ejercicios para las rutinas.</p>
                        <a href="/Dynasty/DYNASTY_WEB_proyecto/View/vEjercicio/GestionEjercicios.php" class="btn-accion">Gestionar</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel-card">
                        <i class="fa fa-list-alt"></i>
                        <span class="numero">&mdash;</span>
                        <h4>Rutinas y asignaciones</h4>
                        <p>Disponible en la siguiente versión del sistema.</p>
                        <span class="btn-accion btn-deshabilitado">Próximamente</span>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="row g-cards">
                <div class="col-md-6">
                    <div class="panel-card">
                        <i class="fa fa-calendar-check-o"></i>
                        <h4>Mi rutina</h4>
                        <p>La consulta de su rutina asignada estará disponible en la siguiente versión.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel-card">
                        <i class="fa fa-line-chart"></i>
                        <h4>Mi progreso</h4>
                        <p>El registro de sus entrenamientos estará disponible en la siguiente versión.</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>

    <?php FooterExterno(); ?>

    <?php ImportJS(); ?>

</body>
</html>
