<div class="row">
    <div class="col-md-12">
        <div class="card card-form">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Id del modulo -->
                        <input type="hidden" name="id_modulo" id="id_modulo" value="<?= $modulo->id_modulo ?>">
                        
                    </div>
                    <!-- Card para agregar un nuevo modulo 
                         Debe tener un boton de + verde en el centro de la card-->
                    <div class="col-md-12">
                        <div class="card card-form">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <i class="fa fa-plus"></i>
                                    Nuevo modulo
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-add d-flex justify-content-center">

                                        <!-- Boton para agregar un nuevo modulo -->
                                        <button type="button" class="btn btn-success w-50" onclick="agregar_modulo()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>