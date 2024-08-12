<!-- Permisos de empresa -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            <!-- Icono -->
            <i class="fas <?= $modulo->icono?>"></i> <?= ucfirst($modulo->nombre_modulo)?>
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

                foreach ($modulo->submodulos as $submodulo) 
                {
                    $nom_submodulo = $submodulo->nombre_submodulo;

                    switch ($nom_modulo) {
                        case 'materia_prima':
                            echo '<div class="col-md-6">';
                            break;

                        case 'seguridad':
                            echo '<div class="col-md-4">';
                            break;

                        case 'documentos':
                            echo '<div class="col-md-12">';
                            break;

                        case 'produccion':
                            echo '<div class="col-md-12">';
                            break;
                        
                        default:
                            echo '<div class="col-md-3">'; 
                            break;
                    }
            ?>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">
                                <?= ucfirst($submodulo->nombre_submodulo)?>
                            </h5>

                            <i class="fas <?= $submodulo->icono?>"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dropdown d-flex justify-content-around">
                            <!-- Recorrer los permisos del modulo y mostrar checkbox-->
                            <?php
                                foreach ($submodulo->acciones as $permiso)
                                {
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>