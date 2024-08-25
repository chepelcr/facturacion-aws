<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php
                        echo view('lotes/nav', array('submodulo'=>'productos', 'modulo'=>'produccion', 'objeto'=>'producto'));
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
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articulos as $key => $articulo):?>
                        <tr>
                            <td><?=$articulo->codigo?></td>
                            <td><?=$articulo->descripcion?></td>
                            <td>
                                <div class="dropdown text-center">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">Opciones</button>
                                    <!--Modificar articulo-->

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <!--Modificar articulo-->
                                        <button id="modificar" value="<?=$articulo->id_producto?>" class="dropdown-item"
                                            type="button">Modificar</button>

                                        <!-- Desactivar producto -->
                                        <?php if ($articulo->estado == 1):?>
                                        <button id="desactivar" value="<?=$articulo->id_producto?>"
                                            class="dropdown-item" type="button">Desactivar</button>
                                        <?php else:?>
                                        <button id="activar" value="<?=$articulo->id_producto?>" class="dropdown-item"
                                            type="button">Activar</button>
                                        <?php endif;?>

                                        <!-- Si el tipo de articulo es produccion, mostrar boton para ver materia prima -->
                                        <?php if ($articulo->tipo_producto == 'P'):?>
                                        <button id="verMateriaPrima" value="<?=$articulo->id_producto?>"
                                            class="dropdown-item" type="button">Ver Materia Prima</button>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </td>
                            <!--Fin de las opciones-->
                        </tr>
                        <!--Fin de la fila-->
                        <?php endforeach;?>
                        <!--Fin del ciclo-->
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


<!--Modal para agregar o modificar un articulo-->
<?php
    echo view('base/form', $dataModal);


    echo view('producto/produccion/cabys');
?>