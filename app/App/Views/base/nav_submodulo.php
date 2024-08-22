<li class="nav-item p-1">
    <a class="nav-link btn btn-secondary justify-content-around nav-modulo nav-<?= $nombre_modulo ?>" data-toggle="tooltip" title="<?= $nombre_vista ?>" href="#" role="button" onclick="cargar_inicio_modulo('<?= $nombre_modulo ?>', '<?= $nombre_vista ?>')">
        <?php
        if ($icono != 'walmart') :
        ?>
            <i class="fa-solid <?= $icono ?> nav-icon"></i>
        <?php
        else :
            echo icono('walmart.png', 'Walmart', 'nav-icon');
        endif;
        ?>
        <span class="nav-title">
            <?= $nombre_vista ?>
        </span>
    </a>
</li>