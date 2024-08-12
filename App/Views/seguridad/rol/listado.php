<!--Card-->
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover" id="listado">
            <thead>
                <tr class="text-center">
                    <th class="col-1">ID</th>
                    <th class="col-7">Nombre del rol</th>
                    <th class="col-2">Estado</th>
                    <th class="col-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($roles as $rol):?>
                <tr class="text-center">
                    <td><?=$rol->id_rol?></td>
                    <td><?=ucfirst($rol->nombre_rol)?></td>
                    <td>
                        <?php 
                                if($rol->estado == 1){
                                    echo '<span class="badge badge-success">Activo</span>';
                                }else{
                                    echo '<span class="badge badge-danger">Inactivo</span>';
                            }?></td>
                    <td>
                    <?= get_botones($rol->id_rol, 'rol', 'seguridad', 'roles',  $rol->estado)?>
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

<!--Modal para agregar o modificar un rol-->
<?php 
    echo view('base/form', $dataModal);    
?>