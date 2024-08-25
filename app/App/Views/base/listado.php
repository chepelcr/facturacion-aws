<!-- Tabla -->
<?php echo view('base/table', $data_tabla);?>
<!-- Fin del listado -->

<!--Form para agregar, modificar o ver un objeto -->
<?php echo view('base/form', $data_form);?>
<!-- Fin del formulario -->

<?php
    if(isset($extra_views))
    {
        foreach ($extra_views as $vista => $data) {
            echo view($vista, $data);
        }
    }
?>