<thead>
    <tr align="center">
        <th class="col-1">Icono</th>
        <th class="col-7">Nombre</th>

        <th class="col-2">Acciones</th>
    </tr>
</thead>

<tbody>
    <?php foreach ($modulos as $modulo): ?>
        <tr>
            <td>
                <?php
                if ($modulo->icono != 'walmart') {
                ?>
                    <i class="fa-solid <?= $modulo->icono ?>"></i>
                <?php
                } else {
                    echo icono('walmart.png', 'Walmart');
                }
                ?>
            </td>
            <td><?= ucfirst($modulo->nombre_modulo) ?></td>
            <!--<td>
                <?php
                if ($modulo->estado == 1) {
                    echo '<span class="badge badge-success">Activo</span>';
                } else {
                    echo '<span class="badge badge-danger">Inactivo</span>';
                } ?></td>-->
            <td>
                <?= get_botones($modulo->id_modulo, 'modulo', 'configuracion', 'modulos') ?>
            </td>
            <!--Fin de las opciones-->
        </tr>
        <!--Fin de la fila-->
    <?php endforeach; ?>
    <!--Fin del ciclo-->
</tbody>
<!--/Cuerpo de la tabla-->