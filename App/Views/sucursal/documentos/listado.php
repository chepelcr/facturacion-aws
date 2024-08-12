<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover" id="listado">
            <thead class=" bg-info">
                <tr>
                    <th>Fecha</th>
                    <th>Consecutivo</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentos as $key => $documento):?>
                <tr>
                    <td><?=$documento->fecha?></td>
                    <td><?=$documento->consecutivo?></td>
                    <td><?=$documento->receptor_nombre?></td>
                    <td>¢ <?=number_format($documento->total_comprobante,"2",",",".") ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opciones
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                    href="<?=baseUrl('pdf/facturaPDF/'.$documento->id_documento)?>">Ver
                                    PDF</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>