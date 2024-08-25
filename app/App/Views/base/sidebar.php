<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="<?= baseUrl() ?>" class="brand-link">
        <img src="<?= getFile('dist/img/logo.png') ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Modas Laura</span>
    </a>

    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
        <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 442px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible os-viewport-native-scrollbars-overlaid" style="overflow-y: scroll;">
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">

                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="<?= getFile('dist/img/logo.png') ?>" class="img-circle elevation-2" alt="User">
                        </div>
                        <div class="info">
                            <a href="#" type="button" class="nav-modulo d-block" onclick="abrir_perfil()" data-toggle="tooltip" title="Perfil"><?= getSession('nombre_usuario') ?></a>
                        </div>
                    </div>

                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <?php
                            echo view('sidebar/dashboard');

                            foreach ($modulos as $modulo) {
                                $data = array(
                                    'modulo' => $modulo->nombre_modulo,
                                    'icono' => $modulo->icono,
                                    'submodulos' => $modulo->submodulos
                                );

                                echo view('sidebar/modulo', $data);
                            }
                            ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="height: 28.127%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar-corner"></div>
    </div>
</aside>