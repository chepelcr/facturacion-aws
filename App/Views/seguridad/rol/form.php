<div class="row">
    <input class="id_rol" name="id_rol" type="hidden">

    <!-- Nombre del rol -->
    <div class="col-md-12">
        <div class="card card-form">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fa fa-pencil-square-o"></i> 
                    Nombre del rol
                </h4>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Cerrar">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <!-- Icono de rol -->
                                <i class="fas fa-user-tag"></i>
                            </div>
                        </div>
                        <input class="form-control inp nombre_rol" name="nombre_rol" type="text"
                            placeholder="Nombre del rol" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <?php echo view('seguridad/rol/elementos/permisos', array('modulos'=>$modulos))?>
    </div>
</div>