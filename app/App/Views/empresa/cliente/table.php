<thead>
    <tr>
        <th class="col-2">Identificación</th>
        <th class="col-5">Nombre completo</th>
        <th class="col-3">Correo electrónico</th>
        <th class="col-3">Acciones</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($clientes as $key => $cliente):?>
    <tr>
        <td class="col-2"><?=formatear_cedula($cliente->identificacion, $cliente->id_tipo_identificacion)?></td>
        <td class="col-5"><?=$cliente->razon?></td>
        <td class="col-3"><?=$cliente->correo?></td>
        <td class="col-2">
            <?= get_botones($cliente->id_cliente, 'cliente', 'empresa', 'clientes', $cliente->estado)?>
        </td>
        <!--Fin de las opciones-->
    </tr>
    <!--Fin de la fila-->
    <?php endforeach;?>
    <!--Fin del ciclo-->
</tbody>
<!--/Cuerpo de la tabla-->