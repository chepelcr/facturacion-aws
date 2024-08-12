<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Informacion</h4>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <?= view('empresa/cliente/form')?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <!-- Ver productos -->
                    <div class="col-md-4">
                        <a href="<?=baseUrl('empresa/productos')?>" class="btn btn-primary btn-block">
                            <i class="fas fa-box-open"></i> Productos
                        </a>
                    </div>

                    <!-- Ver clientes -->
                    <div class="col-md-4">
                        <a href="<?=baseUrl('empresa/clientes')?>" class="btn btn-primary btn-block">
                            <i class="fas fa-users"></i> Clientes
                        </a>
                    </div>

                    <!-- Ver ordenes -->
                    <div class="col-md-4">
                        <a href="<?=baseUrl('empresa/ordenes')?>" class="btn btn-primary btn-block">
                            <i class="fas fa-clipboard-list"></i> Ordenes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>