<!--Card-->
<div class="card">
    <div class="card-header">
        <?= view('seguridad/auditoria/nav')?>
    </div>

    <div class="card-body scroll_vertical" style="max-height: 350px;">
        <table class="table table-bordered table-hover text-center" id="listado_seguridad_auditorias">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tabla</th>
                    <th>Fila</th>
                    <th>Accion</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auditorias as $auditoria):?>
                <tr>
                    <td><?=$auditoria->created_at?></td>
                    <td><?=$auditoria->tabla?></td>
                    <td><?=$auditoria->id_fila?></td>
                    <td><?=$auditoria->accion?></td>
                    <td><?=$auditoria->nombre_usuario?> </td>
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