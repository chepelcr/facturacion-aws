<div class="container nav-modulo pb-5" id="nav-<?=$nombre_modulo?>">
    <div class="container-fluid">
        <div class="d-flex justify-content-around">
            <div class="col-10 bg-gradient-gray rounded p-2 pl-3 pr-3">
                <div class="row">
                    <!-- Recorrer los submodulos -->
                    <?php 
                        foreach ($submodulos as $submodulo):
                            $nombre_submodulo = $submodulo->nombre_submodulo;
                    ?>
                    <div class="col col-lg col-md col-sm p-1">
                        <button class="btn btn-dark btn-modulo w-100 btn_<?=$nombre_modulo.'_'.$nombre_submodulo?>"
                            type="button" onclick="cargar_listado('<?=$nombre_modulo?>', '<?=$nombre_submodulo?>')">
                            <?=ucfirst($nombre_submodulo)?>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>