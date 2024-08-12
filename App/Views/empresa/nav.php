<?php
    if(isset($objeto) && validar_permiso(getSegment(1), $submodulo, 'insertar'))
    {
?>
<div class="col-md-9">
    <nav class="nav nav-pills flex-column flex-sm-row text-center">
        <!-- Clientes -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa/clientes') ?>">
            Clientes
        </a>

        <!-- Productos -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa/productos') ?>">
            Productos
        </a>

        <!-- Documentos -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa/documentos') ?>">
            Documentos
        </a>

        <!-- Ordenes -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa/ordenes') ?>">
            Ordenes
        </a>

        <!-- Informacion -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa') ?>">
            Información
        </a>
    </nav>
</div>

<div class="col-md-3 p-1">
    <?php if((string) $objeto != 'documento'):?>
    <button class="btn btn-danger w-100" type="button" id="btnAgregar">Agregar <?=$objeto?></button>
    <?php 
        else:
    ?>
    <!-- Si el objeto es un documento, mostrar opciones factura, nota de credito, tiquete, otros-->
    <div class="btn-group w-100">
        <button class="btn btn-danger dropdown-toggle w-100" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Agregar
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= baseUrl('documentos') ?>">Factura</a>
            <a class="dropdown-item" href="<?= baseUrl('documentos/nota-credito') ?>">Nota de crédito</a>
            <a class="dropdown-item" href="<?= baseUrl('documentos/tiquete') ?>">Tiquete</a>
            <a class="dropdown-item" href="<?= baseUrl('documentos/nuevo') ?>">Otros</a>
        </div>
    </div>
    <?php endif;?>
</div>
<?php
    }
    
    else 
    {
?>
<div class="col-md-12">
    <nav class="nav nav-pills flex-column flex-sm-row text-center">
        <!-- Clientes -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa/clientes') ?>">
            Clientes
        </a>

        <!-- Productos -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa/productos') ?>">
            Productos
        </a>

        <!-- Documentos -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa/documentos') ?>">
            Documentos
        </a>

        <!-- Ordenes -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa/ordenes') ?>">
            Ordenes
        </a>

        <!-- Informacion -->
        <a class="flex-sm-fill text-sm-center nav-link"
            href="<?= baseUrl('empresa') ?>">
            Información
        </a>
    </nav>

    <?php
    }
?>