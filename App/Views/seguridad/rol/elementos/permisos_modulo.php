<!-- Permisos de empresa -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            <!-- Icono -->

            <?php
                if($modulo->icono != 'walmart'):
            ?>
            <i class="fa-solid <?= $modulo->icono?>"></i>
            <?php
                else:
                    echo icono('walmart.png', 'Walmart');
                endif;
            ?>

            <!-- Titulo -->
            <?= ucfirst(str_replace('_', ' ', $modulo->nombre_modulo))?>
        </h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Recorrer los submodulos de sucursal -->
            <?php
                $nom_modulo = $modulo->nombre_modulo;

                $submodulos = $modulo->submodulos;
                $cantidad_submodulos = count((array) $submodulos);
                
                $submodulos_recorridos = 0;

                foreach ($modulo->submodulos as $submodulo) 
                {
                    $submodulos_recorridos++;

                    switch ($cantidad_submodulos) {
                        case '1':
                            echo '<div class="col-md-12">';
                            break;

                        case '2':
                            echo '<div class="col-md-6">';
                            break;

                        case '3':
                            echo '<div class="col-md-4">';
                            break;

                        case '4':
                            echo '<div class="col-md-3">';
                            break;

                        case '5':
                            if($submodulos_recorridos <= 3)
                            {
                                echo '<div class="col-md-4">';
                            }
                            else
                            {
                                echo '<div class="col-md-6">';
                            }
                            break;

                        case '6':
                            echo '<div class="col-md-4">';
                            break;

                        case '7':
                            if($submodulos_recorridos <= 5)
                            {
                                echo '<div class="col-md-3">';
                            }
                            else
                            {
                                echo '<div class="col-md-6">';
                            }
                            break;
                    }
            ?>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">
                            <?= ucfirst(str_replace('_', ' ', $submodulo->nombre_submodulo))?>
                        </h5>

                        <?php if($nom_modulo == 'walmart' && $submodulo->nombre_submodulo == 'ordenes'):?>
                            <i class="fa-brands <?= $submodulo->icono?>"></i>
                        <?php else:?>
                            <i class="fa-solid <?= $submodulo->icono?>"></i>
                        <?php endif;?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dropdown d-flex justify-content-around">
                        <!-- Recorrer los permisos del modulo y mostrar checkbox-->
                        <?php
                            foreach ($submodulo->acciones as $permiso):
                                $nom_permiso = $permiso->nombre_accion;
                        ?>

                        <!--Agregar un boton -->
                        <button type="button"
                            class="btn btn-secondary inp btn-permiso btn_<?='permiso_'.$modulo->nombre_modulo.'_'.$submodulo->nombre_submodulo.'_'.$permiso->nombre_accion; ?>"
                            data-toggle="tooltip" title="<?= ucfirst($permiso->nombre_accion)?>"
                            onclick="marcar_permiso('<?=$modulo->nombre_modulo?>', '<?=$submodulo->nombre_submodulo?>', '<?=$permiso->nombre_accion?>')">
                            <i class="fas <?= $permiso->icono?>"></i>
                        </button>

                        <div class="form-group form-check" hidden>
                            <input type="checkbox" class="form-check-input inp inp-chk"
                                id="<?='permiso_'.$modulo->nombre_modulo.'_'.$submodulo->nombre_submodulo.'_'.$permiso->nombre_accion; ?>"
                                name="<?='permiso_'.$modulo->nombre_modulo.'_'.$submodulo->nombre_submodulo.'_'.$permiso->nombre_accion; ?>">
                        </div>

                        <?php 
                            endforeach;
                            //Fin del ciclo
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</div>