<!-- Menu de modulo -->
<li class="nav-item" id="menu-<?=$modulo?>">
    <a href="<?=baseUrl($modulo)?>" class="nav-link nv-<?=$modulo?>">
        <i class="fas <?=$icono?> nav-icon"></i>
        <p><?=$modulo?></p>
        <i class="right fas fa-angle-left"></i>
    </a>


    <ul class="nav nav-treeview">
        <?php
            //Submodulos
            foreach($submodulos as $submodulo)
            {
                echo '<!-- '.$submodulo->nombre_submodulo.'  -->
                        <li class="nav-item">
                            <a href="'. baseUrl($modulo.'/'.$submodulo->nombre_submodulo).'" class="nav-link">
                                <p>'.$submodulo->nombre_submodulo.'</p>
                                <i class="fas '.$submodulo->icono.' nav-icon right"></i>
                            </a>
                        </li>';
            }
        ?>
    </ul>
</li>