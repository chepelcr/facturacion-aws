<!--Panel para asignar los permisos de los modulos a un rol especifico -->
<div class="card card-permisos card-form">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-user-lock"></i> 
            Permisos de rol
        </h2>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <?php
            //Recorrer los modulos
            foreach ($modulos as $modulo) {
                echo view('seguridad/rol/elementos/permisos_modulo', array('modulo' => $modulo));
            }
        ?>
    </div>
</div>