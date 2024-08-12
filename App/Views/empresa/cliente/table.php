<thead>
    <tr>
        <th class="col-2">Identificación</th>
        <th class="col-5">Nombre completo</th>
        <th class="col-3">Correo electrónico</th>
        <th class="col-3">Acciones</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($clientes as $key => $customer):?>
    <tr>
        <td class="col-2"><?=formatear_cedula($customer->identification->number, $customer->identification->code)?></td>
        <td class="col-5"><?=$customer->businessName?></td>
        <td class="col-3"><?=$customer->email?></td>
        <td class="col-2">
            <?= get_botones($customer->id, 'cliente', 'empresa', 'clientes', $customer->status)?>
        </td>
        <!--Fin de las opciones-->
    </tr>
    <!--Fin de la fila-->
    <?php endforeach;?>
    <!--Fin del ciclo-->
</tbody>
<!--/Cuerpo de la tabla-->