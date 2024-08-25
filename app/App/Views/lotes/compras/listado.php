<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php
                        echo view('lotes/nav', array('submodulo'=>'lotes', 'modulo'=>'compras' , 'objeto'=>'lote'));
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <!--Card-->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover" id="listado">
                    <thead>
                        <tr>
                            <th class="col-1">Id</th>
                            <th class="col-4">Fecha de creacion</th>
                            <th class="col-4">Valor</th>
                            <th class="col-2">Estado</th>
                            <th class="col-1">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><?= date('c');?></td>
                            <td>$1.000.000</td>
                            <td>PROCESO</td>
                            <td>
                                <div class="dropdown text-center">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">Opciones</button>
                                    <!--Modificar articulo-->

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button class="dropdown-item" type="button">Ver detalle</button>
                                        <button class="dropdown-item" id="btn_desactivar" value="1"
                                            type="button">Finalizar</button>
                                    </div>
                                </div>

                            </td>
                            <!--Fin de las opciones-->
                        </tr>
                        <!--Fin de la fila-->
                    </tbody>
                    <!--/Cuerpo de la tabla-->
                </table>
                <!--/Table-->
            </div>
            <!--/Card body-->
        </div>
        <!--/Card-->
    </div>
</div>


<!--Modal para agregar o modificar un usuario-->
<?php echo view('base/form', $dataModal);?>