<thead>
    <tr>
        <th class="col-2">Numero de cédula</th>
        <th class="col-4">Nombre completo</th>
        <th class="col-1">Rol</th>
        <th class="col-1">Estado</th>
        <th class="col-2">Acciones</th>
    </tr>
</thead>

<tbody>
    <?php foreach ($usuarios as $key => $usuario) : ?>
        <tr>
            <td class="col-2"><?= formatear_cedula($usuario->identificacion, $usuario->id_tipo_identificacion) ?></td>
            <td class="col-4"><?= $usuario->nombre ?></td>
            <td class="col-1"><?= $usuario->nombre_rol ?></td>
            <td class="col-1">
                <?php
                switch ($usuario->estado) {
                    case 1:
                        echo '<span class="badge badge-success">Activo</span>';
                        break;

                    case 0:
                        echo '<span class="badge badge-danger">Inactivo</span>';
                        break;

                    case 2:
                        echo '<span class="badge badge-warning">Pendiente</span>';
                        break;

                    default:
                        //Bloqueado
                        echo '<span class="badge badge-danger">Bloqueado</span>';
                } ?>
            </td>
            <td class="col-2">
                <?= get_botones($usuario->id_usuario, 'usuario', 'seguridad', 'usuarios',  $usuario->estado) ?>
            </td>
            <!--Fin de las opciones-->
        </tr>
        <!--Fin de la fila-->
    <?php endforeach; ?>
    <!--Fin del ciclo-->
</tbody>
<!--/Cuerpo de la tabla-->