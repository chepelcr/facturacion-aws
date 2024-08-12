<div class="card card-table">
    <div class="card-body">
        <table class="table table-bordered table-hover text-center" id="<?=$nombre_tabla?>">
            <?php
                if(isset($nombreTable))
                {
                    if(isset($dataTable))
                        echo view($nombreTable, $dataTable);

                    else
                        echo view($nombreTable);
                }//Fin de la validacion
            ?>
        </table>
        <!--/Table-->
    </div>
    <!--/Card body-->

    <!--Card footer-->
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <label for="id_estado" class="pr-1">Mostrar:</label>
                    <select class="form-control form-control-sm" id="id_estado" name="id_estado" onchange="recargar_listado(this.value)">
                        <option value="all" <?php if(isset($id_estado) && $id_estado == 'all') echo 'selected'?>>Todos</option>
                        <option value="activos" <?php if(isset($id_estado) && $id_estado == 'activos') echo 'selected'?>>Activos</option>
                        <?=var_dump($estado)?>
                        <option value="inactivos" <?php if(isset($id_estado) && $id_estado == 'inactivos') echo 'selected'?>>Inactivos</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/Card-->