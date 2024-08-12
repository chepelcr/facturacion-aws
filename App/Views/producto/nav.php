<?php
    if(validar_permiso(getSegment(1), $submodulo, 'insertar'))
    {
?>
    <div class="col-md-9 pr-1">
        <nav class="nav nav-pills flex-column flex-sm-row text-center">
            <a class="flex-sm-fill text-sm-center nav-link pr-1" href="<?=baseUrl('compras/productos')?>">Compras</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="<?=baseUrl('produccion/productos')?>">Produccion</a>
        </nav>
    </div>

    <div class="col-md-3">
        <button class="btn btn-danger w-100" type="button" id="btnAgregar">Agregar producto</button>
</div>
<?php
    }
    
    else 
    {
?>
    <div class="col-md-12">
        <nav class="nav nav-pills flex-column flex-sm-row text-center">
            <a class="flex-sm-fill text-sm-center nav-link pr-1" href="<?=baseUrl('compras/productos')?>">Compras</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="<?=baseUrl('produccion/productos')?>">Produccion</a>
        </nav>
    </div>

<?php
    }
?>