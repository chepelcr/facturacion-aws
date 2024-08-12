<?php
/*if (count((array) $submodulos) > 0) :
?>
    <li class="nav-item p-1" id="nav-<?= $nombre_modulo ?>">
        <a class="btn btn-secondary justify-content-around nav-modulo nav-<?= $nombre_modulo ?>" href="#" role="button" data-toggle="tooltip" title="<?= $nombre_vista ?>" onclick="cargar_inicio_modulo('<?= $nombre_modulo?>', '<?=$nombre_vista ?>')">
            <?php
            if ($icono != 'walmart') :
            ?>
                <i class="fa-solid <?= $icono ?> nav-icon"></i>
            <?php
            else :
                echo icono('walmart.png', 'Walmart', 'nav-icon');
            endif;
            ?>

            <span class="">
                <?= $nombre_vista ?>
            </span>
        </a>
    </li>

<?php
else :
?>

    <li class="nav-item">
        <button class="btn btn-secondary nav-modulo nav-<?= $nombre_modulo ?>" data-toggle="tooltip" title="<?= $nombre_vista ?>" onclick="cargar_inicio_modulo('<?= $nombre_modulo ?>')" type="button">
            <i class="fa <?= $icono ?> nav-icon"></i>
        </button>
    </li>

<?php
endif; */
?>

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