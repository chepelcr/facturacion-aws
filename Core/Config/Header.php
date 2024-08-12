<?php
    namespace Core\Config;

    /**Clase para manejar la barra de navegación de la aplicacion */
    class Header
    {
        /**Establecer la página a mostrar como aplicacion pdf */
        public static function pdf()
        {
            header('Content-type: application/pdf');
        }//Fin de la funcion

        /**Redireccionar a una direccion especifica */
        public static function redirect($url)
        {
            header('Location:'.$url);
        }//Fin de la funcion para redireccionar
    }//Fin de la clase
?>