<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 titulo-pagina">
                    <?php
                    $empresa = getSession('empresa');
                    $empresa = json_decode($empresa);

                    echo $empresa->tradeName ?? $empresa->businessName;
                    ?>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="modulo-pagina" href="#">Inicio</a></li>
                    <li class="breadcrumb-item active submodulo-pagina">Dash</li>
                </ol>
            </div>
        </div>
    </div>
</section>