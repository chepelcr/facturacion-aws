<thead>
    <tr>
        <th class="col-2">Número de departamento</th>
        <th class="col-4">Nombre</th>
        <th class="col-2">Opciones</th>
    </tr>
</thead>
<tbody id="departamentos">
    <?php foreach ($departamentos as $departamento):?>
    <tr>
        <td class="col-2"><?=$departamento->numero_departamento?></td>
        <td class="col-4">
            <?php
                $nombre = (string) $departamento->nombre;

                //Quitar los espacios en blanco al inicio
                $nombre = ltrim($nombre);

                //Quitar los espacios en blanco al final
                $nombre = rtrim($nombre);

                //Poner solo en minúsculas menos la primer letra de cada palabra
                $nombre = ucwords(strtolower($nombre));

                //Si hay alguna vocal tildada (Á, É, Í, Ó, Ú), ponerla sin tilde
                $nombre = str_replace('Á', 'á', $nombre);
                $nombre = str_replace('É', 'é', $nombre);
                $nombre = str_replace('Í', 'í', $nombre);
                $nombre = str_replace('Ó', 'ó', $nombre);
                $nombre = str_replace('Ú', 'ú', $nombre);
                ?>

            <?=$nombre?></td>
        <td class="col-2">
            <?= get_botones($departamento->id_departamento, 'departamento', 'walmart', 'departamentos', $departamento->estado)?>
        </td>
        <!--Fin de las opciones-->
    </tr>
    <!--Fin de la fila-->
    <?php endforeach;?>
    <!--Fin del ciclo-->
</tbody>
<!--/Cuerpo de la tabla-->