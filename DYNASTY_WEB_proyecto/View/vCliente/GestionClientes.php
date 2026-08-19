<?php
/* ============================================================
 * Proyecto : Dynasty - Sistema de gestion de rutinas
 * Curso    : Ambiente Web Cliente/Servidor (SC-502)
 * Archivo  : GestionClientes.php
 * Proposito: Vista de clientes. Listado, edicion y desactivacion de clientes.
 * ============================================================ */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/Controller/ClienteController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Dynasty/DYNASTY_WEB_proyecto/View/LayoutInterno.php';

    // La vista solicita la informacion al controlador (patron MVC)
    $clientes = ConsultarClientes();
    $niveles  = ConsultarNiveles();
?>
<!DOCTYPE html>
<html lang="es">

<?php ImportCSS(); ?>

<body>

    <?php
        HeaderInterno();
        BreadcrumbInterno("Gestión de clientes");
    ?>

    <section class="seccion-sistema">
        <div class="container-fluid">

            <?php
                Alertas([
                    "actualizacion" => "Cliente actualizado correctamente.",
                    "estado"        => "Estado del cliente actualizado correctamente."
                ]);
            ?>

            <div class="fila-encabezado">
                <div>
                    <div class="section-title">
                        <span>Administración</span>
                        <h2>Clientes registrados</h2>
                    </div>
                </div>
            </div>

            <!-- Formulario de edición (RF02) -->
            <div class="form-sistema oculto" id="formEditarCliente">
                <h3>Editar cliente</h3>
                <form action="" method="post">
                    <input type="hidden" name="idCliente" id="edit_idCliente">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Identificación *</label>
                            <input type="text" name="identificacion" id="edit_identificacion" maxlength="25" required>
                        </div>
                        <div class="col-md-4">
                            <label>Nombre *</label>
                            <input type="text" name="nombre" id="edit_nombre" maxlength="80" required>
                        </div>
                        <div class="col-md-4">
                            <label>Apellidos *</label>
                            <input type="text" name="apellidos" id="edit_apellidos" maxlength="120" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Correo electrónico *</label>
                            <input type="email" name="correo" id="edit_correo" maxlength="150" required>
                        </div>
                        <div class="col-md-4">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" id="edit_telefono" maxlength="20">
                        </div>
                        <div class="col-md-4">
                            <label>Nivel *</label>
                            <select name="nivel" id="edit_nivel" required>
                                <?php foreach($niveles as $n): ?>
                                    <option value="<?= htmlspecialchars($n['codigo_nivel']) ?>"><?= htmlspecialchars($n['descripcion']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Objetivo principal *</label>
                            <input type="text" name="objetivo" id="edit_objetivo" maxlength="180" required>
                        </div>
                        <div class="col-md-6">
                            <label>Disponibilidad semanal *</label>
                            <input type="text" name="disponibilidad" id="edit_disponibilidad" maxlength="120" required>
                        </div>
                    </div>
                    <label>Observaciones</label>
                    <textarea name="observaciones" id="edit_observaciones" maxlength="500"></textarea>
                    <button type="submit" name="btnActualizarCliente" class="site-btn">Guardar cambios</button>
                    <button type="button" class="btn-accion peligro ml-10" onclick="cancelarEdicionCliente();">Cancelar</button>
                </form>
            </div>

            <!-- Listado -->
            <div class="tabla-scroll">
                <table class="tabla-sistema" id="tablaClientesLista">
                    <thead>
                        <tr>
                            <th>Identificación</th>
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Nivel</th>
                            <th>Objetivo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($clientes) > 0): ?>
                            <?php foreach($clientes as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c["identificacion"]) ?></td>
                                    <td><?= htmlspecialchars($c["nombre"] . " " . $c["apellidos"]) ?></td>
                                    <td><?= htmlspecialchars($c["correo"]) ?></td>
                                    <td><?= htmlspecialchars($c["nivel_actual"]) ?></td>
                                    <td><?= htmlspecialchars($c["objetivo_principal"]) ?></td>
                                    <td>
                                        <?php if($c["estado"] == 1): ?>
                                            <span class="estado-activo">Activo</span>
                                        <?php else: ?>
                                            <span class="estado-inactivo">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn-accion"
                                            data-id="<?= $c["id_cliente"] ?>"
                                            data-identificacion="<?= htmlspecialchars($c["identificacion"]) ?>"
                                            data-nombre="<?= htmlspecialchars($c["nombre"]) ?>"
                                            data-apellidos="<?= htmlspecialchars($c["apellidos"]) ?>"
                                            data-correo="<?= htmlspecialchars($c["correo"]) ?>"
                                            data-telefono="<?= htmlspecialchars($c["telefono"]) ?>"
                                            data-objetivo="<?= htmlspecialchars($c["objetivo_principal"]) ?>"
                                            data-nivel="<?= htmlspecialchars($c["nivel_actual"]) ?>"
                                            data-disponibilidad="<?= htmlspecialchars($c["disponibilidad_semanal"]) ?>"
                                            data-observaciones="<?= htmlspecialchars($c["observaciones"]) ?>"
                                            onclick="editarCliente(this);">Editar</button>

                                        <form action="" method="post" class="form-inline"
                                            onsubmit="return confirmarEstado(this, '¿Está seguro de que desea <?= $c["estado"] == 1 ? "desactivar" : "activar" ?> este cliente?');">
                                            <input type="hidden" name="idCliente" value="<?= $c["id_cliente"] ?>">
                                            <input type="hidden" name="estado" value="<?= $c["estado"] == 1 ? 0 : 1 ?>">
                                            <!-- El envio se hace desde JavaScript tras la confirmacion, y en ese
                                                 caso el nombre del boton no viaja. Por eso se envia como campo oculto. -->
                                            <input type="hidden" name="btnCambiarEstadoCliente" value="1">
                                            <button type="submit"
                                                class="btn-accion <?= $c["estado"] == 1 ? "peligro" : "" ?>">
                                                <?= $c["estado"] == 1 ? "Desactivar" : "Activar" ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
