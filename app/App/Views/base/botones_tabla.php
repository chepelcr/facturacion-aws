<div class="dropdown dropleft">
    <?php
    if ($estado == 3) {
    ?>
        <!-- Ver informacion-->
        <button onclick="obtener('<?= $id ?>', '<?= $objeto ?>', 'eliminado');" type="button" data-toggle="tooltip"
            title="Ver <?= $objeto ?> eliminado" class="btn btn-info btn-ver">
            <i class="fas fa-eye"></i>
        </button>
    <?php
    } else {
    ?>

        <!-- Ver informacion-->
        <button onclick="obtener('<?= $id ?>', '<?= $objeto ?>', 'ver');" type="button" data-toggle="tooltip"
            title="Ver <?= $objeto ?>" class="btn btn-info btn-ver">
            <i class="fas fa-eye"></i>
        </button>
        <?php
    }
    if (validar_permiso($modulo, $submodulo, 'modificar')) {
        if ($estado != 3) {
        ?>
            <!-- Modificar -->
            <button onclick="obtener('<?= $id ?>', '<?= $objeto ?>', 'editar');" type="button" data-toggle="tooltip"
                title="Modificar <?= $objeto ?>" class="btn btn-warning btn-modificar">
                <i class="fas fa-pencil-alt"></i>
            </button>

            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>


            <div class="dropdown-menu dropdown-menu-right p-0">
                <div class="dropdown-item p-1">
                    <?php
                    switch ($submodulo) {
                        case 'usuarios':
                    ?>
                            <!-- Si el estado del usuario es 1 -->
                            <?php
                            if ($estado == 1) {
                            ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- Enviar contrasenia -->
                                        <button onclick="enviar_contrasenia('<?= $id ?>');" type="button"
                                            class="btn btn-info btn-enviar-contrasenia btn-sm btn-block" data-toggle="tooltip"
                                            title="Enviar contraseña">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </div>

                                    <div class="col-md-4">
                                        <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 2);" type="button" <?php if ($id == getSession('id_usuario')) {
                                                                                                                                echo 'disabled';
                                                                                                                            } ?>
                                            class="btn btn-danger btn-desactivar btn-sm btn-block" data-toggle="tooltip"
                                            title="Desactivar <?= $objeto ?>">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    </div>

                                    <!-- Eliminar usuario -->
                                    <div class="col-md-4">
                                        <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 3);" type="button"
                                            class="btn btn-danger btn-eliminar btn-sm btn-block" data-toggle="tooltip"
                                            title="Eliminar <?= $objeto ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>

                            <?php
                            } elseif ($estado == 2) {
                            ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 1);" type="button"
                                            class="btn btn-success btn-activar btn-sm btn-block" data-toggle="tooltip"
                                            title="Activar <?= $objeto ?>">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Eliminar usuario -->
                                        <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 3);" type="button"
                                            class="btn btn-danger btn-eliminar btn-sm btn-block" data-toggle="tooltip"
                                            title="Eliminar <?= $objeto ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>


                            <?php
                            } else {
                            ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Enviar contrasenia -->
                                        <button onclick="enviar_contrasenia('<?= $id ?>');" type="button"
                                            class="btn btn-info btn-enviar-contrasenia btn-sm btn-block" data-toggle="tooltip"
                                            title="Enviar contraseña">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php }
                            break;
                        case 'clientes':
                            ?>

                            <!-- Ver documentos -->
                            <div class="col-md-4">
                                <button onclick="ver_documentos('<?= $id ?>', '<?= $objeto ?>');" type="button"
                                    class="btn btn-danger btn-ver-documentos btn-sm btn-block" data-toggle="tooltip"
                                    title="Ver documentos" disabled>
                                    <i class="fas fa-file-alt"></i>
                                </button>
                            </div>

                            <div class="col-md-4">
                                <!-- Si el estado del cliente es 1 -->
                                <?php
                                if ($estado == 1) {
                                ?>
                                    <!-- Si el estado del cliente es 1, desactivar -->
                                    <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 2);" type="button"
                                        class="btn btn-danger btn-desactivar btn-sm btn-block" data-toggle="tooltip"
                                        title="Desactivar <?= $objeto ?>">
                                        <i class="fas fa-user-times"></i>
                                    </button>

                                <?php
                                } elseif ($estado == 2) {
                                ?>
                                    <!-- Si el estado del cliente es 0, activar -->
                                    <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 1);" type="button"
                                        class="btn btn-success btn-activar btn-sm btn-block" data-toggle="tooltip"
                                        title="Activar <?= $objeto ?>">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="col-md-4">
                                <!-- Eliminar cliente -->
                                <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 3);" type="button"
                                    class="btn btn-danger btn-eliminar btn-sm btn-block" data-toggle="tooltip"
                                    title="Eliminar <?= $objeto ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        <?php
                            break;

                        default:
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if ($estado == 1) {
                                    ?>

                                        <!-- Si el estado del objeto es 1, desactivar -->
                                        <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 2);" type="button" class="btn btn-danger btn-block btn-sm btn-desactivar"
                                            data-toggle="tooltip" title="Desactivar <?= $objeto ?>">
                                            <i class="fas fa-times"></i>
                                        </button>

                                    <?php
                                    } elseif ($estado == 2) {
                                    ?>
                                        <!-- Si el estado del objeto es 0, activar -->
                                        <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 1);" type="button" class="btn btn-success btn-block btn-sm btn-activar"
                                            data-toggle="tooltip" title="Activar <?= $objeto ?>">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php
                                    }

                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <!-- Eliminar objeto -->
                                    <button onclick="change_status('<?= $id ?>', '<?= $objeto ?>', 3);" type="button" class="btn btn-danger btn-block btn-sm btn-eliminar"
                                        data-toggle="tooltip" title="Eliminar <?= $objeto ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                    <?php
                            break;
                    }
                    ?>
                </div>
            </div>
        <?php
        } else {
        ?>
            <!-- Reinsertar -->
            <button onclick="obtener('<?= $id ?>', '<?= $objeto ?>', 'reinsertar');" type="button" class="btn btn-warning btn-reinsertar" data-toggle="tooltip"
                title="Reinsertar <?= $objeto ?>">
                <i class="fas fa-redo"></i>
            </button>
    <?php
        }
    }
    ?>
</div>