<!-- Menu de empresa -->
<li class="nav-item" id="menu-empresa">
    <a href="#" class="nav-link nv-empresa">
        <i class="fas fa-lightbulb nav-icon"></i>
        <p>Empresa</p>
        <i class="right fas fa-angle-left"></i>
    </a>


    <ul class="nav nav-treeview">
        <?php

        foreach($submodulos as $submodulo)
        {
            echo '<!-- '.(string)$submodulo->nombre_submodulo.' -->
                    <li class="nav-item">
                        <a href="'. baseUrl('empresa/'.$submodulo->nombre_submodulo).'" class="nav-link">
                            <p>'.$submodulo->nombre_submodulo.'</p>
                            <i class="fas fa-'.$submodulo->icono.' nav-icon right"></i>
                        </a>
                    </li>';
        }
        ?>
    </ul>
</li>


<!-- Menu de documentos -->
<li class="nav-item" id="menu-doc">
    <a href="#" class="nav-link" id="doc">
        <i class="fas fa-file-alt nav-icon"></i>
        <p>Documentos</p>
        <i class="right fas fa-angle-left"></i>
    </a>

    <ul class="nav nav-treeview">
        <?php
        //Facturas
        if(isset($submodulos['facturacion']))
        {
            echo 
            '<!-- Facturas  -->
                <li class="nav-item">
                    <a href="'. baseUrl('documentos').'" class="nav-link">
                        <p>Factura</p>
                        <i class="fas fa-file-invoice nav-icon right"></i>
                    </a>
                </li>';

            echo
            '<!-- Tiquete electronico -->
                <li class="nav-item">
                    <a href="'. baseUrl('documentos/tiquete').'" class="nav-link">
                        <p>Tiquete electronico</p>
                        <i class="fas fa-file-invoice nav-icon right"></i>
                    </a>
                </li>';

            echo
            '<!-- Nuevo -->
                <li class="nav-item">
                    <a href="'. baseUrl('documentos/nuevo').'" class="nav-link">
                        <p>Nuevo</p>
                        <i class="fas fa-file-invoice nav-icon right"></i>
                    </a>
                </li>';
                
            echo 
            '<!-- Documentos -->
                <li class="nav-item">
                    <a href="'. baseUrl('empresa/documentos').'" class="nav-link">
                        <p>Documentos</p>
                        <i class="fas fa-file-invoice nav-icon right"></i>
                    </a>
                </li>';
        }?>
    </ul>
</li>