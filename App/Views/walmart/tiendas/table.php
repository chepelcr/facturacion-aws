<thead>
    <tr>
        <th class="col-2">Número de tienda</th>
        <th class="col-4">Nombre</th>
        <th class="col-2">Opciones</th>
    </tr>
</thead>
<tbody id="tiendas">
    <?php foreach ($tiendas as $tienda):?>
    <tr>
        <td class="col-2"><?=$tienda->id_tienda?></td>
        <td class="col-4">
            <?php
                $nombre_tienda = (string) $tienda->nombre;

                //Quitar los espacios en blanco al inicio
                $nombre_tienda = ltrim($nombre_tienda);

                //Quitar los espacios en blanco al final
                $nombre_tienda = rtrim($nombre_tienda);

                //Poner solo en minúsculas menos la primer letra de cada palabra
                $nombre_tienda = ucwords(strtolower($nombre_tienda));

                //Si hay alguna vocal tildada (Á, É, Í, Ó, Ú), ponerla sin tilde
                $nombre_tienda = str_replace('Á', 'á', $nombre_tienda);
                $nombre_tienda = str_replace('É', 'é', $nombre_tienda);
                $nombre_tienda = str_replace('Í', 'í', $nombre_tienda);
                $nombre_tienda = str_replace('Ó', 'ó', $nombre_tienda);
                $nombre_tienda = str_replace('Ú', 'ú', $nombre_tienda);
                ?>

            <?=$nombre_tienda?></td>
        <td class="col-2">
            <?= get_botones($tienda->id_tienda, 'tienda', 'walmart', 'tiendas', $tienda->estado)?>
        </td>
        <!--Fin de las opciones-->
    </tr>
    <!--Fin de la fila-->
    <?php endforeach;?>
    <!--Fin del ciclo-->
</tbody>
<!--/Cuerpo de la tabla-->