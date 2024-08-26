<?= createScript("var empresa = '" . getSession('empresa_nombre_comercial') . "';") ?>

<!-- jQuery -->
<script src="<?= getFile('dist/plugins/jquery/jquery.min.js') ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?= getFile('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- AdminLTE App -->
<script src="<?= getFile('dist/js/adminlte.min.js') ?>"></script>

<!-- Pace -->
<script src="<?= getFile('dist/plugins/pace-progress/pace.min.js') ?>"></script>

<!-- overlayScrollbars -->
<script src="<?= getFile('dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Font-Awesome -->
<script src="https://kit.fontawesome.com/3e7bda16db.js" crossorigin="anonymous"></script>

<!--DataTables-->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<!-- DataTables || Select -->
<?= getScript('https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min') ?>

<!-- Base | Mensajes -->
<?= getScript('base/mensajes') ?>

<!-- Base | Login -->
<?= getScript('base/login') ?>

<?php
if (is_login()) {
?>

    <!-- Base | Nav -->
    <?= getScript('base/nav') ?>

    <!-- Base | Modulos -->
    <?= getScript('base/modulos') ?>

    <!-- Base | Listado -->
    <?= getScript('base/listado') ?>

    <!-- Base | Ubicaciones -->
    <?= getScript('base/ubicaciones') ?>

    <!-- Form | Campos -->
    <?= getScript('form/campos') ?>

    <!-- Form | Operaciones -->
    <?= getScript('form/operaciones') ?>

    <!-- Form || Permisos -->
    <?= getScript('form/permisos') ?>

    <!-- Empresa || Productos -->
    <?= getScript('empresa/productos') ?>

    <!-- Empresa || Clientes -->
    <?= getScript('empresa/clientes') ?>

    <!-- Empresa || Cabys -->
    <?= getScript('empresa/cabys') ?>

    <!-- Facturacion | Inicio | Documentos -->
    <?= getScript('facturacion/inicio/acciones') ?>

    <!-- Facturacion | Inicio | Hacienda -->
    <?= getScript('facturacion/inicio/hacienda') ?>

    <!-- Facturacion | Documento | Acciones -->
    <?= getScript('facturacion/documento/acciones') ?>

    <!-- Facturacion | Documento | Clientes -->
    <?= getScript('facturacion/documento/clientes') ?>

    <!-- Facturacion | Documento | Lineas -->
    <?= getScript('facturacion/documento/lineas') ?>

    <!-- Facturacion | Documento | Otros -->
    <?= getScript('facturacion/documento/otros') ?>

    <!-- Facturacion | Documento | Productos -->
    <?= getScript('facturacion/documento/productos') ?>

    <!-- Facturacion | Documento | Referencias -->
    <?= getScript('facturacion/documento/referencias') ?>

    <!-- Facturacion | Documento | Walmart -->
    <?= getScript('facturacion/documento/walmart') ?>

    <!-- Facturacion | Lineas | Descuentos -->
    <?= getScript('facturacion/lineas/descuentos') ?>

    <!-- Facturacion | Lineas | Impuestos -->
    <?= getScript('facturacion/lineas/impuestos') ?>

    <?= getScript('https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min') ?>

    <!-- Core | Plugins | Impresion | ConectorEscposAndroid -->
    <?= getScript('core/plugins/impresion/JSPrintManager') ?>

    <!-- Core | Plugins | Impresion -->
    <?= getScript('core/plugins/impresion/impresion') ?>

    <!-- Seguridad | Usuarios -->
    <?= getScript('seguridad/usuarios') ?>

    <!-- Seguridad | Configuracion -->
    <?= getScript('seguridad/configuracion') ?>

<?php
} //is_login

if (isset($script)) {
    echo $script;
}
?>