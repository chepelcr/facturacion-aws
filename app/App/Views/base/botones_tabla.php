<div class="dropdown dropleft">
    <!-- Ver informacion-->
    <button onclick="obtener('<?= $id ?>', '<?= $objeto ?>', true);" type="button" data-toggle="tooltip"
        title="Ver <?= $objeto ?>" class="btn btn-info btn-ver">
        <i class="fas fa-eye"></i>
    </button>

    <?php
        if (validar_permiso($modulo, $submodulo, 'modificar')) {
    ?>
    <!-- Modificar -->
    <button onclick="obtener('<?= $id ?>', '<?= $objeto ?>');" type="button" data-toggle="tooltip"
        title="Modificar <?= $objeto ?>" class="btn btn-warning btn-modificar">
        <i class="fas fa-pencil-alt"></i>
    </button>

    <?php
        if($submodulo == 'usuarios' || $submodulo == 'clientes'){
    ?>
    <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
    </button>


    <div class="dropdown-menu dropdown-menu-right p-0">
        <div class="dropdown-item p-1">
            <div class="row">
                <?php
                    switch ($submodulo) {
                        case 'usuarios':
                ?>

                <div class="col-md-12">
                    <!-- Si el estado del usuario es 1 -->
                    <?php
                        if ($estado == 1) :
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Si el estado del usuario es 1, desactivar -->
                            <button onclick="deshabilitar('<?= $id ?>', '<?= $objeto ?>');" type="button"
                                class="btn btn-danger btn-desactivar btn-sm btn-block" data-toggle="tooltip"
                                title="Desactivar <?= $objeto ?>">
                                <i class="fas fa-user-times"></i>
                            </button>
                        </div>

                        <div class="col-md-6">
                            <!-- Enviar contrasenia -->
                            <button onclick="enviar_contrasenia('<?= $id ?>');" type="button"
                                class="btn btn-info btn-enviar-contrasenia btn-sm btn-block" data-toggle="tooltip"
                                title="Enviar contraseña">
                                <i class="fas fa-key"></i>
                            </button>
                        </div>
                    </div>

                    <?php
                        else:
                            if($estado == 0):
                    ?>
                    <!-- Si el estado del usuario es 0, activar -->
                    <button onclick="habilitar('<?= $id ?>', '<?= $objeto ?>');" type="button"
                        class="btn btn-success btn-activar btn-sm btn-block" data-toggle="tooltip"
                        title="Activar <?= $objeto ?>">
                        <i class="fas fa-user-check"></i>
                    </button>
                    <?php
                        else:
                    ?>
                    <!-- Enviar contrasenia -->
                    <button onclick="enviar_contrasenia('<?= $id ?>');" type="button"
                        class="btn btn-info btn-enviar-contrasenia btn-sm btn-block" data-toggle="tooltip"
                        title="Enviar contraseña">
                        <i class="fas fa-key"></i>
                    </button>
                    <?php
                        endif;
                        endif;
                    ?>
                </div>
                <?php
                        break;
                        case 'clientes':
                ?>
                <!-- Ver documentos -->
                <div class="col-md-6">
                    <button onclick="ver_documentos('<?= $id ?>', '<?= $objeto ?>');" type="button"
                        class="btn btn-danger btn-ver-documentos btn-sm btn-block" data-toggle="tooltip"
                        title="Ver documentos" disabled>
                        <i class="fas fa-file-alt"></i>
                    </button>
                </div>

                <div class="col-md-6">
                    <!-- Si el estado del usuario es 1 -->
                    <?php
                        if ($estado == 1) :
                    ?>
                    <!-- Si el estado del usuario es 1, desactivar -->
                    <button onclick="deshabilitar('<?= $id ?>', '<?= $objeto ?>');" type="button"
                        class="btn btn-danger btn-desactivar btn-sm btn-block" data-toggle="tooltip"
                        title="Desactivar <?= $objeto ?>">
                        <i class="fas fa-user-times"></i>
                    </button>

                    <?php
                        else:
                            if($estado == 0):
                    ?>
                    <!-- Si el estado del usuario es 0, activar -->
                    <button onclick="habilitar('<?= $id ?>', '<?= $objeto ?>');" type="button"
                        class="btn btn-success btn-activar btn-sm btn-block" data-toggle="tooltip"
                        title="Activar <?= $objeto ?>">
                        <i class="fas fa-user-check"></i>
                    </button>
                    <?php
                        endif;
                        endif;
                    ?>
                </div>
                <?php
                        break;
                    }
                ?>
            </div>
        </div>
    </div>

    <?php
        }
    ?>

    <!-- Si isset($estado) -->
    <?php
        if (isset($estado) && $submodulo != 'usuarios' && $submodulo != 'clientes') {
            if($estado == 1){
    ?>

    <!-- Si el estado del usuario es 1, desactivar -->
    <button onclick="deshabilitar('<?= $id ?>', '<?= $objeto ?>');" type="button" class="btn btn-danger btn-desactivar"
        data-toggle="tooltip" title="Desactivar <?= $objeto ?>">
        <i class="fas fa-times"></i>
    </button>

    <?php
            }else{
                if(isset($estado)):
        ?>
    <!-- Si el estado del usuario es 0, activar -->
    <button onclick="habilitar('<?= $id ?>', '<?= $objeto ?>');" type="button" class="btn btn-success btn-activar"
        data-toggle="tooltip" title="Activar <?= $objeto ?>">
        <i class="fas fa-check"></i>
    </button>
    <?php
                    endif;
                }
            }
        }
    ?>
</div>