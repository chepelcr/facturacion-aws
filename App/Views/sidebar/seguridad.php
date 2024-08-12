<!-- Menu de seguridad -->
<li class="nav-item" id="menu-art">
    <a href="#" class="nav-link" id="art">
        <i class="fas fa-shield-alt nav-icon"></i>
        <p>Seguridad</p>
        <i class="right fas fa-angle-left"></i>
    </a>

    <ul class="nav nav-treeview">
    <?php
            //Usuarios
            if(isset($submodulos['usuarios']))
            {
                echo 
                '<!-- Listado Usuarios -->
                    <li class="nav-item">
                        <a href="'. baseUrl('seguridad').'" class="nav-link">
                            <p>Usuarios</p>
                            <i class="fas fa-people-carry nav-icon right"></i>
                        </a>
                    </li>';
            }

            //Roles
            if(isset($submodulos['roles']))
            {
                echo 
                '<!-- Listado Roles -->
                    <li class="nav-item">
                        <a href="'. baseUrl('seguridad/roles').'" class="nav-link">
                            <p>Roles</p>
                            <i class="fas fa-user-tag nav-icon right"></i>
                        </a>
                    </li>';
            }

            //Auditorias
            if(isset($submodulos['auditorias']))
            {
                echo 
                '<!-- Listado Auditorias -->
                    <li class="nav-item">
                        <a href="'. baseUrl('seguridad/auditorias').'" class="nav-link">
                            <p>Auditorias</p>
                            <i class="fas fa-history nav-icon right"></i>
                        </a>
                    </li>
                    
                    <!-- Listado Errores -->
                    <li class="nav-item">
                        <a href="'. baseUrl('seguridad/errores').'" class="nav-link">
                            <p>Errores</p>
                            <i class="fas fa-exclamation-triangle nav-icon right"></i>
                        </a>
                    </li>';
            }
        ?>
    </ul>
</li>