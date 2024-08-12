<nav class="main-header navbar navbar-expand-md navbar-dark bg-modas">
    <a href="#" class="navbar-brand">
        <img src="<?= getFile('dist/img/logo.png') ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= getSession('nombre_usuario') ?></span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#appNavbarContent" aria-controls="appNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="appNavbarContent">
        <ul class="navbar-nav mr-auto">
            <!-- Inicio -->
            <li class="nav-item p-1">
                <a class="nav-link btn btn-secondary justify-content-around nav-modulo nav-inicio" onclick="cargar_inicio()" data-toggle="tooltip" title="Inicio" href="#" role="button">
                    <i class="fas fa-home nav-icon"></i>
                    <span class="nav-title">Inicio</span>
                </a>
            </li>

            <!-- Modulos -->
            <?php foreach ($modulos as $modulo) :
                echo view('base/nav_submodulo', $modulo);
            endforeach;
            ?>
        </ul>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <!-- Perfil -->
                <button class="btn btn-secondary nav-modulo" data-toggle="tooltip" title="Perfil" onclick="abrir_perfil()" type="button">
                    <i class="fas fa-user-circle nav-icon"></i>
                </button>
            </li>

            <li class="nav-item dropdown">
                <!-- Notificaciones -->
                <button class="btn nav-menu" title="Notificaciones" data-toggle="tooltip" disabled type="button">
                    <i class="fas fa-bell nav-icon"></i>
                    <span class="badge badge-warning">1</span>
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

            <li class="nav-item">
                <!-- Salir -->
                <button class="btn btn-secondary nav-modulo" data-toggle="tooltip" title="Salir" onclick="salir()" type="button">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                </button>
            </li>
        </ul>
    </div>
</nav>