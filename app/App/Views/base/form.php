<div class="card card-frm scroll_vertical">

    <!-- Inicio del formulario -->
    <form id="<?=$nombre_form?>">
        <!-- Contenido del modal -->
        <div class="card-body">
            <div class="container">
                <div class="container-fluid">
                    <?php
                                if(isset($nombreForm))
                                {
                                    if(isset($dataForm))
                                        echo view($nombreForm, $dataForm);

                                    else
                                        echo view($nombreForm);
                                }//Fin de la validacion
                            ?>
                </div>
            </div>
        </div>
    </form>
</div>