<div class="row">
    <!-- Id de la departamento -->
    <input type="number" hidden name="id_departamento" class="id_departamento">

    <!-- Datos generales -->
    <div class="col-md-12">
        <div class="card card-form">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fa fa-pencil-square-o"></i>
                    Datos del departamento
                </h4>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Cerrar">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Nombre del departamento -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre del departamento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- Icono de departamento -->
                                        <i class="fas fa-store"></i>
                                    </div>
                                </div>
                                <input class="form-control inp nombre" name="nombre" type="text"
                                    placeholder="Nombre del departamento" required>
                            </div>
                        </div>
                    </div>

                    <!-- Numero de departamento -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="numero_departamento">Numero de departamento</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- Icono de departamento -->
                                        <i class="fas fa-store"></i>
                                    </div>
                                </div>
                                <input class="form-control inp numero_departamento" name="numero_departamento" type="text"
                                    placeholder="Numero de departamento" required>
                            </div>
                        </div>
                    </div>

                    <!-- Numero de proveedor -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="numero_proveedor">Numero de proveedor</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- Icono de proveedor -->
                                        <i class="fas fa-store"></i>
                                    </div>
                                </div>
                                <input class="form-control inp numero_proveedor" name="numero_proveedor" type="text"
                                    placeholder="Numero de proveedor" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>