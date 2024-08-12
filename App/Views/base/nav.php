<div class="collapse" id="navbar_collapse">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-modas navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav col-8 justify-content-between">
            <a href="#" class="navbar-brand">
                <img src="<?=getFile('dist/img/logo.png')?>" alt="Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light"><?=getSession('nombre_usuario')?></span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Inicio -->
            <li class="nav-item">
                <button class="btn btn-secondary nav-modulo nav-inicio" data-toggle="tooltip" title="Inicio"
                    onclick="cargar_inicio()" type="button">
                    <i class="fas fa-home nav-icon"></i>
                </button>
            </li>

            <!-- Modulos -->
            <?php foreach ($modulos as $modulo):
            $nombre_modulo = $modulo->nombre_modulo;
            $nombre_vista = $modulo->nombre_vista;
            $icono = $modulo->icono;
            $submodulos = $modulo->submodulos;

            if(count((array) $submodulos) > 0):
        ?>

            <li class="nav-item dropdown">
                <button class="btn btn-secondary nav-modulo nav-<?=$nombre_modulo?>" data-toggle="tooltip"
                    title="<?=$nombre_vista?>"
                    onclick="cargar_inicio_modulo('<?php echo $modulo->nombre_modulo?>')" type="button">
                    
                    <?php
                        if($modulo->icono != 'walmart'):
                    ?>
                    <i class="fa-solid <?= $modulo->icono?> nav-icon"></i>
                    <?php
                        else:
                            echo icono('walmart.png', 'Walmart', 'nav-icon');
                        endif;
                    ?>
                </button>

                <button type="button"
                    class="btn btn-danger nav-menu dropdown-toggle dropdown-toggle-split nav-menu-<?=$nombre_modulo?>"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>

                <div class="dropdown-menu drp-nav dropdown-menu-left bg-transparent border-0 shadow-none"
                    aria-labelledby="nav-<?=$nombre_modulo?>">
                    <?php
                        foreach ($submodulos as $submodulo):
                            $nombre_submodulo = $submodulo->nombre_submodulo;
                            $nombre_vista_submodulo = $submodulo->nombre_vista;
                            $icono = $submodulo->icono;
                            $url = $submodulo->url;

                            if($nombre_modulo != 'documentos'):
                                if(validar_permiso($nombre_modulo, $nombre_submodulo, 'consultar')):
                            ?>
                            <div class="p-1">
                                <button data-toggle="tooltip" title="<?= $nombre_vista_submodulo?>"
                                    class="w-50 btn btn-dark nav-button btn_<?=$nombre_modulo.'_'.$nombre_submodulo?>"
                                    onclick="cargar_listado('<?=$nombre_modulo?>', '<?=$nombre_submodulo?>', '<?=$nombre_vista?>', '<?=$nombre_vista_submodulo?>', '<?= baseUrl($url)?>')">
                                    <i class="fa-solid <?=$icono?>"></i>
                                </button>
                            </div>
                            <?php
                                endif;

                            else:
                                if($nombre_submodulo != 'importar'):
                            ?>
                            <div class="p-1">
                                <button data-toggle="tooltip" title="<?=$nombre_vista_submodulo?>"
                                    class="w-50 btn btn-dark nav-button btn_<?=$nombre_modulo.'_'.$nombre_submodulo?>"
                                    onclick="cargar_documentos('<?=$nombre_submodulo?>')">
                                    <i class="fa-solid <?=$icono?>"></i>
                                </button>
                            </div>
                            <?php
                                else:
                            ?>
                            <div class="p-1">
                                <button data-toggle="tooltip" title="<?=$nombre_vista_submodulo?>"
                                    class="w-50 btn btn-dark nav-button btn_<?=$nombre_modulo.'_'.$nombre_submodulo?>"
                                    onclick="importar_documentos()">
                                    <i class="fa-solid <?=$icono?>"></i>
                                </button>
                            </div>
                            <?php
                                endif;
                            endif;
                        endforeach;
                    ?>
                </div>
            </li>

            <?php
                else:
            ?>

                <li class="nav-item">
                    <button class="btn btn-secondary nav-modulo nav-<?=$nombre_modulo?>" data-toggle="tooltip"
                    title="<?=$nombre_vista?>" onclick="cargar_inicio_modulo('<?= $modulo->nombre_modulo?>')"
                        type="button">
                        <i class="fa <?=$icono?> nav-icon"></i>
                    </button>
                </li>

                <?php
                endif;
            endforeach;
        ?>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto col-2">
            <li class="nav-item dropdown w-100 d-flex justify-content-between">
                <!-- Perfil -->
                <button class="btn btn-secondary nav-modulo" data-toggle="tooltip" title="Perfil"
                    onclick="abrir_perfil()" type="button">
                    <i class="fas fa-user-circle nav-icon"></i>
                </button>

                <!-- Notificaciones -->
                <button class="btn nav-menu" title="Notificaciones" data-toggle="tooltip" disabled type="button">
                    <i class="fas fa-bell nav-icon"></i>
                    <span class="badge badge-warning">1</span>
                </button>

                <!-- Salir -->
                <button class="btn btn-secondary nav-modulo" data-toggle="tooltip" title="Salir" onclick="salir()"
                    type="button">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                </button>

                <div class="dropdown-menu drp-nav dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">1 Notificacion</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i>Reportes
                        <span class="float-right text-muted text-sm">3</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">Ver todo</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
</div>