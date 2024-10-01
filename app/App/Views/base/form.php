<div class="container card-frm">
    <!-- Inicio del formulario -->
    <form id="<?= $nombre_form ?>">
        <div class="container-fluid">
            <?php
            if (isset($nombreForm)) {
                if (isset($dataForm)) {
                    echo view($nombreForm, $dataForm);
                } else {
                    echo view($nombreForm);
                }
            } //Fin de la validacion
            ?>
        </div>
    </form>
</div>