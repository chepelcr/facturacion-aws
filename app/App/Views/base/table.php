<div class="card card-table">
    <div class="card-body">
        <table class="table table-bordered table-hover text-center mx-auto w-auto" id="<?= $nombre_tabla ?>">
            <?php
            if (isset($nombreTable)) {
                if (isset($dataTable)) {
                    echo view($nombreTable, $dataTable);
                } else {
                    echo view($nombreTable);
                }
            } //Fin de la validacion
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
                    <label for="status" class="pr-1">Mostrar:</label>
                    <select class="form-control form-control-sm" id="status" name="status" onchange="recargar_listado(this.value)">
                        <option value="all" <?php if ((isset($status) && $status == 'all') || !isset($status)) {
                                                echo 'selected';
                                            } ?>>Todos</option>
                        <option value="1" <?php if (isset($status) && $status == '1') {
                                                echo 'selected';
                                            } ?>>Activos</option>
                        <option value="2" <?php if (isset($status) && $status == '2') {
                                                echo 'selected';
                                            } ?>>Inactivos</option>
                        <option value="3" <?php if (isset($status) && $status == '3') {
                                                echo 'selected';
                                            } ?>>Eliminados</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/Card-->