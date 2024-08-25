<!--Card-->
<div class="card">
    <div class="card-header">
        <?= view('seguridad/auditoria/nav')?>
    </div>

    <div class="card-body scroll_vertical" style="max-height: 350px;">
        <table class="table table-bordered table-hover text-center" id="listado_seguridad_errores">
            <thead>
                <tr>
                    <th>Fecha del error</th>
                    <th>Tabla</th>
                    <th>Descripcion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($errores as $error):?>
                <tr>
                    <td><?=$error->createdAt?></td>
                    <td><?=$error->controlador?></td>
                    <td class="text-left"><?=$error->sentencia?></td>
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